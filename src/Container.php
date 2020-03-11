<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AuraPHP
 *
 * @link    https://github.com/auraphp/Aura.Di
 * @license https://github.com/auraphp/Aura.Di/blob/4.x/LICENSE
 */

declare(strict_types=1);

namespace Phalcon;

use Closure;
use Phalcon\Container\Exception;
use Phalcon\Container\Exception\ContainerLocked;
use Phalcon\Container\Exception\NoSuchProperty;
use Phalcon\Container\Exception\ServiceNotFound;
use Phalcon\Container\Exception\ServiceNotObject;
use Phalcon\Container\Injection\Factory;
use Phalcon\Container\Injection\InjectionFactory;
use Phalcon\Container\Injection\Lazy;
use Phalcon\Container\Injection\LazyArray;
use Phalcon\Container\Injection\LazyCallable;
use Phalcon\Container\Injection\LazyGet;
use Phalcon\Container\Injection\LazyInclude;
use Phalcon\Container\Injection\LazyInterface;
use Phalcon\Container\Injection\LazyNew;
use Phalcon\Container\Injection\LazyRequire;
use Phalcon\Container\Injection\LazyValue;
use Phalcon\Container\ResolutionHelper;
use Phalcon\Container\Resolver\AutoResolver;
use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Container\Resolver\ValueObject;
use Psr\Container\ContainerInterface;
use ReflectionException;

/**
 * Dependency injection container.
 *
 * @property ContainerInterface $delegate
 * @property InjectionFactory   $factory
 * @property array              $instances
 * @property bool               $locked
 * @property Resolver           $resolver
 * @property array              $services
 */
class Container implements ContainerInterface
{
    /**
     * A container that will be used instead of the main container
     * to fetch dependencies.
     *
     * @var ContainerInterface
     */
    protected ?ContainerInterface $delegate;

    /**
     * A factory to create objects and values for injection.
     *
     * @var InjectionFactory
     */
    protected InjectionFactory $factory;

    /**
     * Retains the actual service object instances.
     *
     * @var array
     */
    protected array $instances = [];

    /**
     * Is the Container locked?  (When locked, you cannot access configuration
     * properties from outside the object, and cannot set services.)
     *
     * @var bool
     */
    protected bool $locked = false;

    /**
     * A Resolver obtained from the InjectionFactory.
     *
     * @var Resolver
     */
    protected Resolver $resolver;

    /**
     * Retains named service definitions.
     *
     * @var array
     */
    protected array $services = [];

    /**
     * Constructor.
     *
     * @param InjectionFactory   $factory           A factory to create objects
     *                                              and values for injection.
     * @param ContainerInterface $delegate          An optional container that
     *                                              will be used to fetch
     *                                              dependencies (i.e. lazy
     *                                              gets)
     */
    public function __construct(
        InjectionFactory $factory,
        ContainerInterface $delegate = null
    ) {
        $this->factory  = $factory;
        $this->resolver = $this->factory->getResolver();
        $this->delegate = $delegate;
    }

    /**
     * Gets a service object by key.
     *
     * @param string $service The service to get.
     *
     * @return object
     *
     * @throws ServiceNotFound when the requested service
     * does not exist.
     */
    public function get($service): object
    {
        $this->locked = true;

        if (isset($this->instances[$service])) {
            return $this->instances[$service];
        }

        $this->instances[$service] = $this->getServiceInstance($service);
        return $this->instances[$service];
    }

    /**
     * Returns the secondary delegate container.
     *
     * @return mixed
     */
    public function getDelegateContainer()
    {
        return $this->delegate;
    }

    /**
     * Returns the InjectionFactory.
     *
     * @return InjectionFactory
     */
    public function getInjectionFactory()
    {
        return $this->factory;
    }

    /**
     * Gets the list of instantiated services.
     *
     * @return array
     */
    public function getInstances(): array
    {
        return array_keys($this->instances);
    }

    /**
     * Gets the list of service definitions.
     *
     * @return array
     */
    public function getServices(): array
    {
        return array_keys($this->services);
    }

    /**
     * Does a particular service definition exist?
     *
     * @param string $service The service key to look up.
     *
     * @return bool
     */
    public function has($service): bool
    {
        if (isset($this->services[$service])) {
            return true;
        }

        return isset($this->delegate)
            && $this->delegate->has($service);
    }

    /**
     * Is the Container locked?
     *
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * Returns a lazy object that calls a callable, optionally with arguments.
     *
     * @param callable|mixed $callable The callable.
     * @param array          $params
     *
     * @return Lazy
     */
    public function lazy($callable, ...$params): Lazy
    {
        return $this->factory->newLazy($callable, $params);
    }

    /**
     * Returns a lazy object that wraps an array that may contain
     * (potentially lazy) callables that get invoked at calltime.
     *
     * @param array $callables The (potentially lazy) array of callables to
     *                         invoke.
     *
     * @return LazyArray
     */
    public function lazyArray(array $callables): LazyArray
    {
        return $this->factory->newLazyArray($callables);
    }

    /**
     * Returns a lazy object that invokes a (potentially lazy) callable with
     * parameters supplied at calltime.
     *
     * @param callable $callable The (potentially lazy) callable.
     *
     * @return LazyCallable
     */
    public function lazyCallable(callable $callable): LazyCallable
    {
        return $this->factory->newLazyCallable($callable);
    }

    /**
     * Returns a lazy object that gets a service.
     *
     * @param string $service The service name; it does not need to exist yet.
     *
     * @return LazyGet
     */
    public function lazyGet(string $service): LazyGet
    {
        return $this->factory->newLazyGet($this, $service);
    }

    /**
     * Returns a lazy object that gets a service and calls a method on it,
     * optionally with parameters.
     *
     * @param string $service   The service name.
     * @param string $method    The method to call on the service object.
     * @param        ...$params mixed Parameters to use in the method call.
     *
     * @return Lazy
     */
    public function lazyGetCall(string $service, string $method, ...$params): Lazy
    {
        $callable = [$this->lazyGet($service), $method];

        return $this->factory->newLazy($callable, $params);
    }

    /**
     * Returns a lazy that includes a file.
     *
     * @param string $file The file to include.
     *
     * @return LazyInclude
     */
    public function lazyInclude(string $file): LazyInclude
    {
        return $this->factory->newLazyInclude($file);
    }

    /**
     * Returns a lazy object that creates a new instance.
     *
     * @param string $class   The type of class of instantiate.
     * @param array  $params  Override parameters for the instance.
     * @param array  $setters Override setters for the instance.
     *
     * @return LazyNew
     */
    public function lazyNew(
        $class,
        array $params = [],
        array $setters = []
    ): LazyNew {
        return $this->factory->newLazyNew($class, $params, $setters);
    }

    /**
     * Returns a lazy that requires a file.
     *
     * @param string $file The file to require.
     *
     * @return LazyRequire
     */
    public function lazyRequire(string $file): LazyRequire
    {
        return $this->factory->newLazyRequire($file);
    }

    /**
     * Returns a lazy for an arbitrary value.
     *
     * @param string $key The arbitrary value key.
     *
     * @return LazyValue
     */
    public function lazyValue(string $key): LazyValue
    {
        return $this->factory->newLazyValue($key);
    }

    /**
     * Locks the Container so that is it read-only.
     *
     * @return void
     */
    public function lock(): void
    {
        $this->locked = true;
    }

    /**
     * @return ValueObject
     * @throws ContainerLocked
     */
    public function mutations(): ValueObject
    {
        $this->checkLocked();

        return $this->resolver->mutations();
    }

    /**
     * Returns a factory that creates an object over and over again (as vs
     * creating it one time like the lazyNew() or newInstance() methods).
     *
     * @param string $class   The factory will create an instance of this class.
     * @param array  $params  Override parameters for the instance.
     * @param array  $setters Override setters for the instance.
     *
     * @return Factory
     *
     */
    public function newFactory(
        string $class,
        array $params = [],
        array $setters = []
    ): Factory {
        return $this->factory->newFactory(
            $class,
            $params,
            $setters
        );
    }

    /**
     * Creates and returns a new instance of a class using reflection and
     * the configuration parameters, optionally with overrides, invoking Lazy
     * values along the way.
     *
     * Note the that container must be locked before creating a new instance.
     * This prevents premature resolution of params and setters.
     *
     * @param string $class        The class to instantiate.
     *
     * @param array  $mergeParams  An array of override parameters; the key may
     *                             be the name *or* the numeric position of the
     *                             constructor parameter, and the value is the
     *                             parameter value to use.
     *
     * @param array  $mergeSetters An array of override setters; the key is the
     *                             name of the setter method to call and the
     *                             value is the value to be passed to the
     *                             setter method.
     *
     * @return object
     * @throws NoSuchProperty
     * @throws ReflectionException
     */
    public function newInstance(
        string $class,
        array $mergeParams = [],
        array $mergeSetters = []
    ): object {
        $this->locked = true;
        return $this->factory->newInstance(
            new Blueprint(
                $class,
                $mergeParams,
                $mergeSetters
            )
        );
    }

    /**
     *
     * Returns a callable object to resolve a service or new instance of a class
     *
     * @return ResolutionHelper
     */
    public function newResolutionHelper(): ResolutionHelper
    {
        return new ResolutionHelper($this);
    }

    /**
     * @return ValueObject
     * @throws ContainerLocked
     */
    public function parameters(): ValueObject
    {
        $this->checkLocked();

        return $this->resolver->parameters();
    }

    /**
     * Sets a service definition by name. If you set a service as a Closure,
     * it is automatically treated as a Lazy. (Note that is has to be a
     * Closure, not just any callable, to be treated as a Lazy; this is
     * because the actual service object itself might be callable via an
     * __invoke() method.)
     *
     * @param string          $service The service key.
     * @param object|callable $val     The service object; if a Closure, is
     *                                 treated as a Lazy.
     *
     * @return $this
     * @throws ServiceNotObject
     *
     * @throws ContainerLocked when the Container is locked.
     */
    public function set(string $service, object $val): Container
    {
        $this->checkLocked();
        if ($val instanceof Closure) {
            $val = $this->factory->newLazy($val);
        }

        $this->services[$service] = $val;

        return $this;
    }

    /**
     * @return ValueObject
     * @throws ContainerLocked
     */
    public function setters(): ValueObject
    {
        $this->checkLocked();
        return $this->resolver->setters();
    }

    /**
     * @return ValueObject|null
     * @throws ContainerLocked
     */
    public function types(): ?ValueObject
    {
        if ($this->resolver instanceof AutoResolver) {
            $this->checkLocked();
            return $this->resolver->types();
        }

        return null;
    }

    /**
     * @return ValueObject
     * @throws ContainerLocked
     */
    public function values(): ValueObject
    {
        $this->checkLocked();

        return $this->resolver->values();
    }

    /**
     * Instantiates a service object by key, lazy-loading it as needed.
     *
     * @param string $service The service to get.
     *
     * @return object
     *
     * @throws ServiceNotFound when the requested service
     * does not exist.
     */
    protected function getServiceInstance(string $service): object
    {
        // does the definition exist?
        if (!$this->has($service)) {
            Exception::serviceNotFound($service);
        }

        // is it defined in this container?
        if (!isset($this->services[$service])) {
            // no, get the instance from the delegate container
            return $this->delegate->get($service);
        }

        // instantiate it from its definition
        $instance = $this->services[$service];

        // lazy-load as needed
        if ($instance instanceof LazyInterface) {
            $instance = $instance();
        }

        // done
        return $instance;
    }

    /**
     * @throws ContainerLocked
     */
    private function checkLocked(): void
    {
        if ($this->locked) {
            Exception::containerLocked();
        }
    }
}

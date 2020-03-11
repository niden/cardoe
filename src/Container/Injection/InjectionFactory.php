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

namespace Phalcon\Container\Injection;

use Phalcon\Container\Exception\NoSuchProperty;
use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Container\Resolver\Resolver;
use Psr\Container\ContainerInterface;
use ReflectionException;

/**
 * A factory to create objects and values for injection into the Container.
 *
 * @property Resolver $resolver
 */
class InjectionFactory
{
    /**
     * A Resolver to provide class-creation specifics.
     *
     * @var Resolver
     */
    protected Resolver $resolver;

    /**
     * Constructor.
     *
     * @param Resolver $resolver A Resolver to provide class-creation specifics.
     */
    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Returns the Resolver.
     *
     * @return Resolver
     */
    public function getResolver(): Resolver
    {
        return $this->resolver;
    }

    /**
     *
     * Returns a new class instance.
     *
     * @param Blueprint $blueprint The blueprint to instantiate.
     *
     * @return object
     * @throws ReflectionException
     * @throws NoSuchProperty
     */
    public function newInstance(Blueprint $blueprint): object
    {
        return $this->resolver->resolve($blueprint);
    }

    /**
     * Returns a new Factory.
     *
     * @param string $class   The class to create.
     * @param array  $params  Override params for the class.
     * @param array  $setters Override setters for the class.
     *
     * @return Factory
     */
    public function newFactory(
        $class,
        array $params = [],
        array $setters = []
    ): Factory {
        return new Factory($this->resolver, new Blueprint($class, $params, $setters));
    }

    /**
     * Returns a new Lazy.
     *
     * @param callable $callable The callable to invoke.
     *
     * @param array    $params   Arguments for the callable.
     *
     * @return Lazy
     */
    public function newLazy($callable, array $params = []): Lazy
    {
        return new Lazy($callable, $params);
    }

    /**
     * Returns a new LazyArray.
     *
     * @param array $callables The callables to invoke.
     *
     * @return LazyArray
     */
    public function newLazyArray(array $callables): LazyArray
    {
        return new LazyArray($callables);
    }

    /**
     * Returns a new LazyCallable.
     *
     * @param callable $callable The callable to invoke.
     *
     * @return LazyCallable
     */
    public function newLazyCallable($callable): LazyCallable
    {
        return new LazyCallable($callable);
    }

    /**
     * Returns a new LazyGet.
     *
     * @param ContainerInterface $container The service container.
     * @param string             $service   The service to retrieve.
     *
     * @return LazyGet
     */
    public function newLazyGet(ContainerInterface $container, string $service): LazyGet
    {
        return new LazyGet($container, $service);
    }

    /**
     * Returns a new LazyInclude.
     *
     * @param string $file The file to include.
     *
     * @return LazyInclude
     */
    public function newLazyInclude(string $file): LazyInclude
    {
        return new LazyInclude($file);
    }

    /**
     * Returns a new LazyNew.
     *
     * @param string $class   The class to instantiate.
     * @param array  $params  Params for the instantiation.
     * @param array  $setters Setters for the instantiation.
     *
     * @return LazyNew
     */
    public function newLazyNew(
        string $class,
        array $params = [],
        array $setters = []
    ): LazyNew {
        return new LazyNew($this->resolver, new Blueprint($class, $params, $setters));
    }

    /**
     * Returns a new LazyRequire.
     *
     * @param string $file The file to require.
     *
     * @return LazyRequire
     */
    public function newLazyRequire(string $file): LazyRequire
    {
        return new LazyRequire($file);
    }

    /**
     * Returns a new LazyValue.
     *
     * @param string $key The value key to use.
     *
     * @return LazyValue
     */
    public function newLazyValue(string $key): LazyValue
    {
        return new LazyValue($this->resolver, $key);
    }
}

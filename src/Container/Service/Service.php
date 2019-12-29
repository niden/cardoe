<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Service;

use Phalcon\Container\Argument\AbstractResolver;
use Phalcon\Container\Argument\ClassNameInterface;
use Phalcon\Container\Argument\RawInterface;
use Phalcon\Container\Argument\ResolverInterface;
use Phalcon\Container\Exception\ContainerException;
use ReflectionClass;
use ReflectionException;

/**
 * Class Service
 *
 * @property string     $name
 * @property mixed      $compiled
 * @property bool       $shared
 * @property array      $arguments
 * @property array      $methods
 * @property mixed|null $resolved
 */
class Service extends AbstractResolver implements ResolverInterface, ServiceInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed|string|null
     */
    protected $compiled;

    /**
     * @var bool
     */
    protected $shared = false;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @var mixed
     */
    protected $resolved = null;

    /**
     * Constructor.
     *
     * @param string $name
     * @param mixed  $compiled
     */
    public function __construct(string $name, $compiled = null)
    {
        $compiled = $compiled ?? $name;

        $this->name     = $name;
        $this->compiled = $compiled;
    }

    /**
     * Adds an argument to the definition
     *
     * @param mixed $argument
     *
     * @return ServiceInterface
     */
    public function addArgument($argument): ServiceInterface
    {
        $this->arguments[] = $argument;

        return $this;
    }

    /**
     * Adds arguments based on the passed array
     *
     * @param array $arguments
     *
     * @return ServiceInterface
     */
    public function addArguments(array $arguments): ServiceInterface
    {
        foreach ($arguments as $argument) {
            $this->addArgument($argument);
        }

        return $this;
    }

    /**
     * Adds a method to the definition
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return ServiceInterface
     */
    public function addMethod(string $method, array $arguments = []): ServiceInterface
    {
        $this->methods[] = [
            "name"      => $method,
            "arguments" => $arguments,
        ];

        return $this;
    }

    /**
     * Adds methods based on the passed array [name => arguments]
     *
     * @param array $methods
     *
     * @return ServiceInterface
     */
    public function addMethods(array $methods = []): ServiceInterface
    {
        foreach ($methods as $method => $arguments) {
            $this->addMethod($method, $arguments);
        }

        return $this;
    }

    /**
     * Returns the name of the definition
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the compiled definition
     *
     * @return mixed
     */
    public function getCompiled()
    {
        return $this->compiled;
    }

    /**
     * Returns if this definition is shared or not
     *
     * @return bool
     */
    public function isShared(): bool
    {
        return $this->shared;
    }

    /**
     * Resolves the definition
     *
     * @param bool $isFresh
     *
     * @return mixed
     */
    public function resolveService(bool $isFresh = false)
    {
        try {
            if ($this->isShared() && $this->resolved !== null && $isFresh === false) {
                return $this->resolved;
            }

            $compiled = $this->compiled;

            if (is_callable($compiled)) {
                $compiled = call_user_func_array(
                    $compiled,
                    $this->resolveArguments($this->arguments)
                );
            }

            if ($compiled instanceof RawInterface) {
                $this->resolved = $compiled->get();

                return $compiled->get();
            }

            if ($compiled instanceof ClassNameInterface) {
                $compiled = $compiled->get();
            }

            if (is_string($compiled) && class_exists($compiled)) {
                $class    = new ReflectionClass($compiled);
                $compiled = $class->newInstanceArgs(
                    $this->resolveArguments($this->arguments)
                );
            }

            if (is_object($compiled)) {
                $compiled = $this->callMethods($compiled);
            }

            $this->resolved = $compiled;

            return $compiled;
        } catch (ReflectionException $ex) {
            throw new ContainerException(
                "Error resolving definition " . $ex->getMessage()
            );
        }
    }

    /**
     * Sets the compiled definition
     *
     * @param mixed $compiled
     *
     * @return ServiceInterface
     */
    public function setCompiled($compiled): ServiceInterface
    {
        $this->compiled = $compiled;
        $this->resolved = null;

        return $this;
    }

    /**
     * Sets the name of this definition
     *
     * @param string $name
     *
     * @return ServiceInterface
     */
    public function setName(string $name): ServiceInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets this definition shared or not
     *
     * @param bool $shared
     *
     * @return ServiceInterface
     */
    public function setShared(bool $shared): ServiceInterface
    {
        $this->shared = $shared;

        return $this;
    }

    /**
     * Invoke methods on resolved instance.
     *
     * @param object $instance
     *
     * @return object
     * @throws ReflectionException
     */
    protected function callMethods($instance)
    {
        foreach ($this->methods as $method) {
            $arguments = $this->resolveArguments($method['arguments']);

            /** @var callable $callable */
            $callable = [$instance, $method['name']];
            call_user_func_array($callable, $arguments);
        }

        return $instance;
    }
}

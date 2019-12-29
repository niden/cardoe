<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Argument;

use Closure;
use Phalcon\Container\Exception\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;

/**
 * Class ReflectionContainer
 *
 * @property array $store
 */
class ReflectionContainer extends AbstractResolver implements ContainerInterface
{
    /**
     * @var array
     */
    protected $store = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     * @param array  $arguments
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     * @throws ReflectionException
     */
    public function get($id, array $arguments = [])
    {
        if (isset($this->store[$id])) {
            return $this->store[$id];
        }

        if (!$this->has($id)) {
            throw new NotFoundException(
                sprintf(
                    '[%s] class cannot be resolved',
                    $id
                )
            );
        }

        $reflector   = new ReflectionClass($id);
        $constructor = $reflector->getConstructor();

        if (null === $constructor) {
            $resolved = new $id();
        } else {
            $resolved = $reflector->newInstanceArgs(
                $this->reflectArguments($constructor, $arguments)
            );
        }

        $this->store[$id] = $resolved;

        return $resolved;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        return class_exists($id);
    }

    /**
     * Invoke a callable via the container.
     *
     * @param callable $callable
     * @param array    $arguments
     *
     * @return mixed
     *
     * @throws ReflectionException
     */
    public function call(callable $callable, array $arguments = [])
    {
        if (is_string($callable) && strpos($callable, '::') !== false) {
            $callable = explode('::', $callable);
        }

        if (is_array($callable)) {
            $class = $callable[0];
            $name  = $callable[1] ?? null;

            if (is_string($class)) {
                $class = $this->getContainer()->get($class);
            }

            $reflection = new ReflectionMethod($class, $name);

            if ($reflection->isStatic()) {
                $class = null;
            }

            return $reflection->invokeArgs(
                $class,
                $this->reflectArguments($reflection, $arguments)
            );
        }

        if (is_object($callable)) {
            $reflection = new ReflectionMethod($callable, '__invoke');

            return $reflection->invokeArgs(
                $callable,
                $this->reflectArguments($reflection, $arguments)
            );
        }

        $reflection = new ReflectionFunction(
            Closure::fromCallable($callable)
        );

        return $reflection->invokeArgs(
            $this->reflectArguments($reflection, $arguments)
        );
    }
}

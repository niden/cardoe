<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Mutator;

use Phalcon\Container\Argument\AbstractResolver;
use Phalcon\Helper\Arr;
use ReflectionException;

/**
 * Class Mutator
 *
 * @property callable|null $callback
 * @property array         $methods
 * @property string        $className
 * @property array         $properties
 */
class Mutator extends AbstractResolver implements MutatorInterface
{
    /**
     * @var callable|null
     */
    protected $callback;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * Mutator constructor.
     *
     * @param string        $className
     * @param callable|null $callback
     */
    public function __construct(string $className, callable $callback = null)
    {
        $this->callback  = $callback;
        $this->className = $className;
    }

    /**
     * Returns the class name of the mutation
     *
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Invokes a method for the mutation
     *
     * @param string $className
     * @param array  $arguments
     *
     * @return MutatorInterface
     */
    public function invokeMethod(string $className, array $arguments): MutatorInterface
    {
        $this->methods[$className] = $arguments;

        return $this;
    }

    /**
     * Invokes methods for the mutation
     *
     * @param array $methods
     *
     * @return MutatorInterface
     */
    public function invokeMethods(array $methods): MutatorInterface
    {
        foreach ($methods as $className => $arguments) {
            $this->invokeMethod($className, $arguments);
        }

        return $this;
    }

    /**
     * Mutates the object
     *
     * @param mixed $object
     *
     * @return mixed|void
     * @throws ReflectionException
     */
    public function mutate($object)
    {
        $this
            ->processProperties($object)
            ->processMethods($object)
            ->processCallback($object)
        ;
    }

    /**
     * Sets a property for the mutation
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return MutatorInterface
     * @throws ReflectionException
     */
    public function setProperty(string $property, $value): MutatorInterface
    {
        $this->properties[$property] = $this->resolveArguments([$value])[0];

        return $this;
    }

    /**
     * Sets properties for the mutation
     *
     * @param array $properties
     *
     * @return MutatorInterface
     * @throws ReflectionException
     */
    public function setProperties(array $properties): MutatorInterface
    {
        foreach ($properties as $property => $value) {
            $this->setProperty($property, $value);
        }

        return $this;
    }

    /**
     * @param mixed $object
     *
     * @return Mutator
     */
    private function processCallback($object): Mutator
    {
        if ($this->callback !== null) {
            call_user_func($this->callback, $object);
        }

        return $this;
    }

    /**
     * @param mixed $object
     *
     * @return Mutator
     * @throws ReflectionException
     */
    private function processMethods($object): Mutator
    {
        foreach ($this->methods as $method => $arguments) {
            $args = $this->resolveArguments($arguments);

            /** @var callable $callable */
            $callable = [$object, $method];
            call_user_func_array($callable, $args);
        }

        return $this;
    }

    /**
     * @param mixed $object
     *
     * @return Mutator
     * @throws ReflectionException
     */
    private function processProperties($object): Mutator
    {
        [$keys, $values] = Arr::split($this->properties);
        $values     = $this->resolveArguments($values);
        $properties = array_combine($keys, $values);

        foreach ($properties as $property => $value) {
            $object->{$property} = $value;
        }

        return $this;
    }
}

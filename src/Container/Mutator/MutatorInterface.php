<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Mutator;

use Phalcon\Container\ContainerAwareInterface;

/**
 * Interface MutatorInterface
 */
interface MutatorInterface extends ContainerAwareInterface
{
    /**
     * Returns the class name of the mutation
     *
     * @return string
     */
    public function getClassName(): string;

    /**
     * Invokes a method for the mutation
     *
     * @param string $className
     * @param array  $arguments
     *
     * @return MutatorInterface
     */
    public function invokeMethod(string $className, array $arguments): MutatorInterface;

    /**
     * Invokes methods for the mutation
     *
     * @param array $methods
     *
     * @return MutatorInterface
     */
    public function invokeMethods(array $methods): MutatorInterface;

    /**
     * Mutates the object
     *
     * @param mixed $object
     *
     * @return mixed
     */
    public function mutate($object);

    /**
     * Sets a property for the mutation
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return MutatorInterface
     */
    public function setProperty(string $property, $value): MutatorInterface;

    /**
     * Sets properties for the mutation
     *
     * @param array $properties
     *
     * @return MutatorInterface
     */
    public function setProperties(array $properties): MutatorInterface;
}

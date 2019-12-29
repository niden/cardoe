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

interface MutatorsInterface extends ContainerAwareInterface
{
    /**
     * Adds a mutator in the collection
     *
     * @param string        $className
     * @param callable|null $callback
     *
     * @return MutatorInterface
     */
    public function add(string $className, callable $callback = null): MutatorInterface;

    /**
     * Mutates an object
     *
     * @param mixed $object
     *
     * @return mixed
     */
    public function mutate($object);

    /**
     * Returns the internal array
     */
    public function toArray(): array;
}

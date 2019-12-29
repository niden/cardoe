<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Mutator;

use Phalcon\Container\AbstractContainerAware;

/**
 * Class Mutators
 *
 * @property MutatorsInterface[] $store
 */
class Mutators extends AbstractContainerAware implements MutatorsInterface
{
    /**
     * @var MutatorInterface[]
     */
    protected $store = [];

    /**
     * Adds a mutator in the collection
     *
     * @param string        $className
     * @param callable|null $callback
     *
     * @return MutatorInterface
     */
    public function add(string $className, callable $callback = null): MutatorInterface
    {
        $mutator = new Mutator($className, $callback);

        $this->store[$className][] = $mutator;

        return $mutator;
    }

    /**
     * Mutates an object
     *
     * @param mixed $object
     *
     * @return mixed
     */
    public function mutate($object)
    {
        $instanceOf = get_class($object);
        if (isset($this->store[$instanceOf])) {
            /** @var MutatorInterface $mutator */
            foreach ($this->store[$instanceOf] as $mutator) {
                $mutator->setContainer($this->getContainer());
                $mutator->mutate($object);
            }
        }

        return $object;
    }

    /**
     * Returns the internal array
     */
    public function toArray(): array
    {
        return $this->store;
    }
}

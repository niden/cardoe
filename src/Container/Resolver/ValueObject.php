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

namespace Phalcon\Container\Resolver;

use function array_key_exists;

/**
 * Class ArrayObject
 *
 * @property array $store
 */
class ValueObject
{
    /**
     * @var array
     */
    protected $store = [];

    /**
     * Clears the internal collection
     */
    public function clear(): void
    {
        $this->store = [];
    }

    /**
     * Count elements of an object
     *
     * @link https://php.net/manual/en/countable.count.php
     */
    public function count(): int
    {
        return count($this->store);
    }

    /**
     * Get the element from the collection
     *
     * @param mixed      $element
     * @param mixed|null $defaultValue
     *
     * @return mixed
     */
    public function get($element, $defaultValue = null)
    {
        if (!$this->has($element)) {
            return $defaultValue;
        }

        return $this->store[$element];
    }

    /**
     * Get the element from the collection
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function has($element): bool
    {
        return array_key_exists($element, $this->store);
    }

    /**
     * @param mixed $element
     * @param array $data
     */
    public function merge($element, array $data)
    {
        $this->store[$element] = array_merge(
            $this->get($element, []),
            $data
        );
    }

    /**
     * Delete the element from the collection
     *
     * @param mixed $element
     */
    public function remove($element): void
    {
        unset($this->store[$element]);
    }

    /**
     * Set an element in the collection
     *
     * @param mixed $element
     * @param mixed $value
     */
    public function set($element, $value): void
    {
        $this->store[$element] = $value;
    }
}

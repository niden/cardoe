<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Storage\Adapter;

/**
 * Interface for Cardoe\Logger adapters
 */
interface AdapterInterface
{
    /**
     * Flushes/clears the cache
     */
    public function clear(): bool;

    /**
     * Decrements a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return int | bool
     */
    public function decrement(string $key, int $value = 1);

    /**
     * Deletes data from the adapter
     *
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key): bool;

    /**
     * Reads data from the adapter
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * Returns the adapter - connects to the storage if not connected
     *
     * @return mixed
     */
    public function getAdapter();

    /**
     * Returns all the keys stored
     */
    public function getKeys(): array;

    /**
     * Returns the prefix for the keys
     */
    public function getPrefix(): string;

    /**
     * Checks if an element exists in the cache
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Increments a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return int | bool
     */
    public function increment(string $key, int $value = 1);

    /**
     * Stores data in the adapter
     *
     * @param string $key
     * @param mixed  $value
     * @param null   $ttl
     *
     * @return bool
     */
    public function set(string $key, $value, $ttl = null): bool;
}

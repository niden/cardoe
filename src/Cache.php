<?php

/**
* This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Cache;

use Phalcon\Cache\Adapter\AdapterInterface;
use Phalcon\Cache\Exception\InvalidArgumentException;
use DateInterval;
use Psr\SimpleCache\CacheInterface;
use Traversable;

use function is_array;

/**
 * This component offers caching capabilities for your application.
 * Phalcon\Cache implements PSR-16.
 *
 * @property AdapterInterface $adapter
 */
class Cache implements CacheInterface
{
    /**
     * The adapter
     *
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Cache constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool True on success and false on failure.
     */
    public function clear(): bool
    {
        return $this->adapter->clear();
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     *
     * @return bool True if the item was successfully removed. False if there
     *              was an error.
     *
     * @throws InvalidArgumentException MUST be thrown if the $key string is
     *                                  not a legal value.
     */
    public function delete($key): bool
    {
        $this->checkKey($key);

        return $this->adapter->delete($key);
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable $keys A list of string-based keys to be deleted.
     *
     * @return bool True if the items were successfully removed. False if there
     *              was an error.
     *
     * @throws InvalidArgumentException MUST be thrown if $keys is neither an
     *                                  array nor a Traversable, or if any of
     *                                  the $keys are not a legal value.
     */
    public function deleteMultiple($keys): bool
    {
        $this->checkKeys($keys);

        $result = true;
        foreach ($keys as $key) {
            if (!$this->adapter->delete($key)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Fetches a value from the cache.
     *
     * @param string $key          The unique key of this item in the cache.
     * @param mixed  $defaultValue Default value to return if the key does not
     *                             exist.
     *
     * @return mixed The value of the item from the cache, or $default in case
     *               of cache miss.
     *
     * @throws InvalidArgumentException MUST be thrown if the $key string is
     *                                  not a legal value.
     */
    public function get($key, $defaultValue = null)
    {
        $this->checkKey($key);

        return $this->adapter->get($key, $defaultValue);
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable $keys         A list of keys that can obtained in a
     *                               single operation.
     * @param mixed    $defaultValue Default value to return for keys that do
     *                               not exist.
     *
     * @return iterable A list of key => value pairs. Cache keys that do not
     *                  exist or are stale will have $default as value.
     *
     * @throws InvalidArgumentException MUST be thrown if $keys is neither an
     *                                  array nor a Traversable, or if any of
     *                                  the $keys are not a legal value.
     */
    public function getMultiple($keys, $defaultValue = null)
    {
        $this->checkKeys($keys);

        $results = [];
        foreach ($keys as $element) {
            $results[$element] = $this->get($element, $defaultValue);
        }

        return $results;
    }

    /**
     * Determines whether an item is present in the cache.
     *
     * @param string $key The cache item key.
     *
     * @return bool
     *
     * @throws InvalidArgumentException MUST be thrown if the $key string is
     *                                  not a legal value.
     */
    public function has($key): bool
    {
        $this->checkKey($key);

        return $this->adapter->has($key);
    }

    /**
     * Persists data in the cache, uniquely referenced by a key with an
     * optional expiration TTL time.
     *
     * @param string                $key    The key of the item to store.
     * @param mixed                 $value  The value of the item to store.
     *                                      Must be serializable.
     * @param null|int|DateInterval $ttl    Optional. The TTL value of this
     *                                      item. If no value is sent and the
     *                                      driver supports TTL then the
     *                                      library may set a default value for
     *                                      it or let the driver take care of
     *                                      that.
     *
     * @return bool True on success and false on failure.
     *
     * @throws InvalidArgumentException MUST be thrown if the $key string is
     *                                  not a legal value.
     */
    public function set($key, $value, $ttl = null): bool
    {
        $this->checkKey($key);

        return $this->adapter->set($key, $value, $ttl);
    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * @param iterable              $values  A list of key => value pairs for a
     *                                       multiple-set operation.
     * @param null|int|DateInterval $ttl     Optional. The TTL value of this
     *                                       item. If no value is sent and the
     *                                       driver supports TTL then the
     *                                       library may set a default value
     *                                       for it or let the driver take care
     *                                       of that.
     *
     * @return bool True on success and false on failure.
     *
     * @throws InvalidArgumentException MUST be thrown if $values is neither an
     *                                  array nor a Traversable, or if any of
     *                                  the $values are not a legal value.
     */
    public function setMultiple($values, $ttl = null): bool
    {
        $this->checkKeys($values);

        $result = true;
        foreach ($values as $key => $value) {
            if (!$this->set($key, $value, $ttl)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Checks the key. If it contains invalid characters an exception is thrown
     *
     * @param mixed $key
     *
     * @throws InvalidArgumentException
     */
    protected function checkKey($key): void
    {
        $key = (string) $key;

        if (preg_match("/[^A-Za-z0-9-_.]/", $key)) {
            throw new InvalidArgumentException(
                "The key contains invalid characters"
            );
        }
    }

    /**
     * Checks the key. If it contains invalid characters an exception is thrown
     *
     * @param mixed $keys
     *
     * @throws InvalidArgumentException
     */
    protected function checkKeys($keys): void
    {
        if (!(is_array($keys) || $keys instanceof Traversable)) {
            throw new InvalidArgumentException(
                "The keys need to be an array or instance of Traversable"
            );
        }
    }
}

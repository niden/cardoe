<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Storage\Adapter;

use DateInterval;
use Phalcon\Collection;
use Phalcon\Factory\Exception as ExceptionAlias;
use Phalcon\Storage\Exception;
use Phalcon\Storage\SerializerFactory;

/**
 * Memory adapter
 *
 * @property Collection $data
 * @property array      $options
 */
class Memory extends AbstractAdapter
{
    /**
     * @var Collection
     */
    protected Collection $data;

    /**
     * @var array
     */
    protected array $options = [];

    /**
     * Memory constructor.
     *
     * @param SerializerFactory $factory
     * @param array             $options
     *
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function __construct(SerializerFactory $factory, array $options = [])
    {
        /**
         * Lets set some defaults and options here
         */
        $this->prefix  = "ph-memo-";
        $this->options = $options;
        $this->data    = new Collection();

        parent::__construct($factory, $options);

        $this->initSerializer();
    }

    /**
     * Flushes/clears the cache
     */
    public function clear(): bool
    {
        $this->data->clear();

        return true;
    }

    /**
     * Decrements a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return bool|int
     */
    public function decrement(string $key, int $value = 1)
    {
        $prefixedKey = $this->getPrefixedKey($key);
        $result      = $this->data->has($prefixedKey);

        if ($result) {
            $current  = $this->data->get($prefixedKey);
            $newValue = (int) $current - $value;
            $result   = $newValue;

            $this->data->set($prefixedKey, $newValue);
        }

        return $result;
    }

    /**
     * Deletes data from the adapter
     *
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key): bool
    {
        $prefixedKey = $this->getPrefixedKey($key);
        $exists      = $this->data->has($prefixedKey);

        $this->data->remove($prefixedKey);

        return $exists;
    }

    /**
     * Reads data from the adapter
     *
     * @param string     $key
     * @param mixed|null $defaultValue
     *
     * @return mixed
     */
    public function get(string $key, $defaultValue = null)
    {
        $prefixedKey = $this->getPrefixedKey($key);
        $content     = $this->data->get($prefixedKey);

        return $this->getUnserializedData($content, $defaultValue);
    }

    /**
     * Always returns null
     *
     * @return null
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Stores data in the adapter
     *
     * @param string $prefix
     *
     * @return array
     */
    public function getKeys(string $prefix = ""): array
    {
        return $this->getFilteredKeys(
            $this->data->getKeys(),
            $prefix
        );
    }

    /**
     * Checks if an element exists in the cache
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        $prefixedKey = $this->getPrefixedKey($key);

        return $this->data->has($prefixedKey);
    }

    /**
     * Increments a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return bool|int
     */
    public function increment(string $key, int $value = 1)
    {
        $prefixedKey = $this->getPrefixedKey($key);
        $result      = $this->data->has($prefixedKey);

        if ($result) {
            $current  = $this->data->get($prefixedKey);
            $newValue = (int) $current + $value;
            $result   = $newValue;

            $this->data->set($prefixedKey, $newValue);
        }

        return $result;
    }

    /**
     * Stores data in the adapter
     *
     * @param string                $key
     * @param mixed                 $value
     * @param DateInterval|int|null $ttl
     *
     * @return bool
     * @throws \Exception
     */
    public function set(string $key, $value, $ttl = null): bool
    {
        $content     = $this->getSerializedData($value);
        $prefixedKey = $this->getPrefixedKey($key);

        $this->data->set($prefixedKey, $content);

        return true;
    }
}

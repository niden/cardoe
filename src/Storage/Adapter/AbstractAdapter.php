<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Storage\Adapter;

use Phalcon\Factory\Exception as ExceptionAlias;
use Phalcon\Helper\Arr;
use Phalcon\Helper\Str;
use Phalcon\Storage\Exception;
use Phalcon\Storage\Serializer\SerializerInterface;
use Phalcon\Storage\SerializerFactory;
use DateInterval;
use DateTime;

use function is_object;
use function var_dump;

/**
 * Class AbstractAdapter
 *
 * @package Phalcon\Storage\Adapter
 *
 * @property mixed               $adapter
 * @property string              $defaultSerializer
 * @property int                 $lifetime
 * @property string              $prefix
 * @property SerializerInterface $serializer
 * @property SerializerFactory   $serializerFactory
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var mixed
     */
    protected $adapter;

    /**
     * Name of the default serializer class
     *
     * @var string
     */
    protected $defaultSerializer = "Php";

    /**
     * Name of the default TTL (time to live)
     *
     * @var int
     */
    protected $lifetime = 3600;

    /**
     * @var string
     */
    protected $prefix = "";

    /**
     * Serializer
     *
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * Serializer Factory
     *
     * @var SerializerFactory
     */
    protected $serializerFactory;

    /**
     * Sets parameters based on options
     *
     * AbstractAdapter constructor.
     *
     * @param SerializerFactory|null $factory
     * @param array                  $options
     */
    protected function __construct(SerializerFactory $factory = null, array $options = [])
    {
        /**
         * Lets set some defaults and options here
         */
        $this->defaultSerializer = Arr::get($options, "defaultSerializer", "Php");
        $this->lifetime          = Arr::get($options, "lifetime", 3600);
        $this->serializer        = Arr::get($options, "serializer", null);
        $this->serializerFactory = $factory;

        if (isset($options["prefix"])) {
            $this->prefix = $options["prefix"];
        }
    }

    /**
     * Flushes/clears the cache
     *
     * @return bool
     */
    abstract public function clear(): bool;

    /**
     * Decrements a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return int | bool
     */
    abstract public function decrement(string $key, int $value = 1);

    /**
     * Deletes data from the adapter
     *
     * @param string $key
     *
     * @return bool
     */
    abstract public function delete(string $key): bool;

    /**
     * Reads data from the adapter
     *
     * @param string     $key
     * @param mixed|null $defaultValue
     *
     * @return mixed
     */
    abstract public function get(string $key, $defaultValue = null);

    /**
     * Returns the adapter - connects to the storage if not connected
     *
     * @return mixed
     */
    abstract public function getAdapter();

    /**
     * @return string
     */
    public function getDefaultSerializer(): string
    {
        return $this->defaultSerializer;
    }

    /**
     * Returns all the keys stored
     *
     * @param string $prefix
     *
     * @return array
     */
    abstract public function getKeys(string $prefix = ""): array;

    /**
     * Returns the prefix
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Checks if an element exists in the cache
     *
     * @param string $key
     *
     * @return bool
     */
    abstract public function has(string $key): bool;

    /**
     * Increments a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return int | bool
     */
    abstract public function increment(string $key, int $value = 1);

    /**
     * Stores data in the adapter
     *
     * @param string                $key
     * @param mixed                 $value
     * @param DateInterval|int|null $ttl
     *
     * @return bool
     */
    abstract public function set(string $key, $value, $ttl = null): bool;

    /**
     * @param string $serializer
     */
    public function setDefaultSerializer(string $serializer): void
    {
        $this->defaultSerializer = $serializer;
    }

    /**
     * Filters the keys array based on global and passed prefix
     *
     * @param mixed  $keys
     * @param string $prefix
     *
     * @return array
     */
    protected function getFilteredKeys($keys, string $prefix): array
    {
        $results = [];
        $pattern = $this->prefix . $prefix;
        $keys    = !$keys ? [] : $keys;

        foreach ($keys as $key) {
            if (Str::startsWith($key, $pattern)) {
                $results[] = $key;
            }
        }

        return $results;
    }

    /**
     * Returns the key requested, prefixed
     *
     * @param string $key
     *
     * @return string
     */
    protected function getPrefixedKey($key): string
    {
        $key = (string) $key;

        return $this->prefix . $key;
    }

    /**
     * Returns serialized data
     *
     * @param mixed $content
     *
     * @return mixed
     */
    protected function getSerializedData($content)
    {
        if ("" !== $this->defaultSerializer) {
            $this->serializer->setData($content);
            $content = $this->serializer->serialize();
        }

        return $content;
    }

    /**
     * Calculates the TTL for a cache item
     *
     * @param DateInterval|int|null $ttl
     *
     * @return int
     * @throws \Exception
     */
    protected function getTtl($ttl): int
    {
        if (null === $ttl) {
            return $this->lifetime;
        }

        if (is_object($ttl) && $ttl instanceof DateInterval) {
            $dateTime = new DateTime("@0");
            return $dateTime->add($ttl)->getTimestamp();
        }

        return (int) $ttl;
    }

    /**
     * Returns unserialized data
     *
     * @param mixed      $content
     * @param mixed|null $defaultValue
     *
     * @return mixed
     */
    protected function getUnserializedData($content, $defaultValue = null)
    {
        if (!$content) {
            return $defaultValue;
        }

        if ("" !== $this->defaultSerializer) {
            $this->serializer->unserialize($content);
            $content = $this->serializer->getData();
        }

        return $content;
    }

    /**
     * Initializes the serializer
     *
     * @throws Exception
     * @throws ExceptionAlias
     */
    protected function initSerializer(): void
    {
        if (null === $this->serializer && null === $this->serializerFactory) {
            throw new Exception("A valid serializer is required");
        }

        if (!is_object($this->serializer)) {
            $className        = strtolower($this->defaultSerializer);
            $this->serializer = $this->serializerFactory->newInstance($className);
        }
    }
}

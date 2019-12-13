<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Collection;

use ArrayAccess;
use ArrayIterator;
use Cardoe\Helper\Json;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Serializable;
use Traversable;

use function array_key_exists;
use function array_keys;
use function array_values;
use function is_object;
use function mb_strtolower;
use function method_exists;
use function strtolower;

/**
 * Cardoe\Collection
 *
 * Cardoe\Collection is a supercharged object oriented array. It implements
 * ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Serializable
 *
 * It can be used in any part of the application that needs collection of data
 * Such implementations are for instance accessing globals `$_GET`, `$_POST`
 * etc.
 *
 * @property array $data
 * @property bool  $insensitive
 * @property array $lowerKeys
*/
class Collection implements
    ArrayAccess,
    Countable,
    IteratorAggregate,
    JsonSerializable,
    Serializable
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var bool
     */
    protected $insensitive = true;

    /**
     * @var array
     */
    protected $lowerKeys = [];

    /**
     * Collection constructor.
     *
     * @param array $data
     * @param bool  $insensitive
     */
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $this->insensitive = $insensitive;
        $this->init($data);
    }

    /**
     * Magic getter to get an element from the collection
     *
     * @param string $element
     *
     * @return mixed
     */
    public function __get(string $element)
    {
        return $this->get($element);
    }

    /**
     * Magic isset to check whether an element exists or not
     *
     * @param string $element
     *
     * @return bool
     */
    public function __isset(string $element): bool
    {
        return $this->has($element);
    }

    /**
     * Magic setter to assign values to an element
     *
     * @param string $element
     * @param mixed  $value
     */
    public function __set(string $element, $value)
    {
        $this->set($element, $value);
    }

    /**
     * Magic unset to remove an element from the collection
     *
     * @param string $element
     */
    public function __unset(string $element): void
    {
        $this->remove($element);
    }

    /**
     * Clears the internal collection
     */
    public function clear(): void
    {
        $this->data      = [];
        $this->lowerKeys = [];
    }

    /**
     * Count elements of an object
     *
     * @link https://php.net/manual/en/countable.count.php
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Get the element from the collection
     *
     * @param string     $element
     * @param mixed|null $defaultValue
     *
     * @return mixed
     */
    /**
     * Get the element from the collection
     */
    /**
     * @param string      $element
     * @param mixed|null  $defaultValue
     * @param string|null $cast
     *
     * @return mixed
     */
    public function get(
        string $element,
        $defaultValue = null,
        string $cast = null
    ) {
        $element = ($this->insensitive) ? strtolower($element) : $element;

        if (!array_key_exists($element, $this->lowerKeys)) {
            return $defaultValue;
        }

        $key   = $this->lowerKeys[$element];
        $value = $this->data[$key];

        if (null !== $cast) {
            settype($value, $cast);
        }

        return $value;
    }

    /**
     * Returns the iterator of the class
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Returns the keys (insensitive or not) of the collection
     *
     * @param bool $insensitive
     *
     * @return array
     */
    public function getKeys(bool $insensitive = true): array
    {
        if ($insensitive) {
            return array_keys($this->lowerKeys);
        } else {
            return array_keys($this->data);
        }
    }

    /**
     * Returns the values of the internal array
     *
     * @return array
     */
    public function getValues(): array
    {
        return array_values($this->data);
    }

    /**
     * Get the element from the collection
     *
     * @param string $element
     *
     * @return bool
     */
    public function has(string $element): bool
    {
        if (true === $this->insensitive) {
            $element = strtolower($element);
        }

        return isset($this->lowerKeys[$element]);
    }

    /**
     * Initialize internal array
     *
     * @param array $data
     */
    public function init(array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->setData($key, $value);
        }
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {
        $records = [];

        foreach ($this->data as $key => $value) {
            if (is_object($value) && method_exists($value, "jsonSerializable")) {
                $records[$key] = $value->jsonSerialize();
            } else {
                $records[$key] = $value;
            }
        }

        return $records;
    }

    /**
     * Whether a offset exists
     *
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function offsetExists($element): bool
    {
        $element = (string) $element;

        return $this->has($element);
    }

    /**
     * Offset to retrieve
     *
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $element
     *
     * @return mixed
     */
    public function offsetGet($element)
    {
        $element = (string) $element;

        return $this->get($element);
    }

    /**
     * Offset to set
     *
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $element
     * @param mixed $value
     */
    public function offsetSet($element, $value): void
    {
        $element = (string) $element;

        $this->set($element, $value);
    }

    /**
     * Offset to unset
     *
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $element
     */
    public function offsetUnset($element): void
    {
        $element = (string) $element;

        $this->remove($element);
    }

    /**
     * Delete the element from the collection
     *
     * @param string $element
     */
    public function remove(string $element): void
    {
        if ($this->has($element)) {
            if (true === $this->insensitive) {
                $element = strtolower($element);
            }

            $value = $this->lowerKeys[$element];

            unset($this->lowerKeys[$element]);
            unset($this->data[$value]);
        }
    }

    /**
     * Set an element in the collection
     *
     * @param string $element
     * @param mixed  $value
     */
    public function set(string $element, $value): void
    {
        $this->setData($element, $value);
    }

    /**
     * String representation of object
     *
     * @link https://php.net/manual/en/serializable.serialize.php
     */
    public function serialize(): string
    {
        return serialize($this->toArray());
    }

    /**
     * Returns the object in an array format
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Returns the object in a JSON format
     *
     * The default string uses the following options for json_encode
     *
     * JSON_HEX_TAG, JSON_HEX_APOS, JSON_HEX_AMP, JSON_HEX_QUOT,
     * JSON_UNESCAPED_SLASHES
     *
     * @see https://www.ietf.org/rfc/rfc4627.txt
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 79): string
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * Constructs the object
     *
     * @link https://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized
     */
    public function unserialize($serialized): void
    {
        $serialized = (string) $serialized;
        $data       = unserialize($serialized);

        $this->init($data);
    }

    /**
     * Internal method to set data
     *
     * @param mixed $element
     * @param mixed $value
     */
    protected function setData($element, $value): void
    {
        $element = (string) $element;
        $key     = (true === $this->insensitive) ? mb_strtolower($element) : $element;

        $this->data[$element]  = $value;
        $this->lowerKeys[$key] = $element;
    }
}

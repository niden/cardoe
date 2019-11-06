<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Config;

use Cardoe\Collection\Collection;
use function array_shift;
use function explode;
use function is_array;
use function is_int;
use function is_object;
use function method_exists;

class Config extends Collection
{
    const DEFAULT_PATH_DELIMITER = ".";

    /**
     * @var string
     */
    protected $pathDelimiter = null;

    /**
     * Gets the default path delimiter
     *
     * @return string
     */
    public function getPathDelimiter(): string
    {
        if (null === $this->pathDelimiter) {
            $this->pathDelimiter = self::DEFAULT_PATH_DELIMITER;
        }

        return $this->pathDelimiter;
    }

    /**
     * Merges a configuration into the current one
     *
     * @param array|Config $toMerge
     *
     * @return Config
     * @throws Exception
     */
    public function merge($toMerge): Config
    {
        if (is_array($toMerge)) {
            $config = new Config($toMerge);
        } elseif (is_object($toMerge) && $toMerge instanceof Config) {
            $config = $toMerge;
        } else {
            throw new Exception(
                "Invalid data type for merge."
            );
        }

        $source = $this->toArray();
        $target = $config->toArray();
        $result = $this->internalMerge($source, $target);

        $this->clear();
        $this->init($result);

        return $this;
    }

    /**
     * Returns a value from current config using a dot separated path.
     *
     * @param string      $path
     * @param null        $defaultValue
     * @param string|null $delimiter
     *
     * @return mixed|null
     */
    public function path(string $path, $defaultValue = null, string $delimiter = null)
    {
        if (true === $this->has($path)) {
            return $this->get($path);
        }

        if (true === empty($delimiter)) {
            $delimiter = $this->getPathDelimiter();
        }

        $config = clone $this;
        $keys   = explode($delimiter, $path);

        while (!empty($keys)) {
            $key = array_shift($keys);

            if (true !== $config->has($key)) {
                break;
            }

            if (true === empty($keys)) {
                return $config->get($key);
            }

            $config = $config->get($key);
            if (true === empty($config)) {
                break;
            }
        }

        return $defaultValue;
    }

    /**
     * Sets the default path delimiter
     *
     * @param string|null $delimiter
     *
     * @return Config
     */
    public function setPathDelimiter(string $delimiter = null): Config
    {
        $this->pathDelimiter = $delimiter;

        return $this;
    }

    /**
     * Converts recursively the object to an array
     *
     * @return array
     */
    public function toArray(): array
    {
        $results = [];
        $data    = parent::toArray();

        foreach ($data as $key => $value) {
            if (is_object($value) &&
                true === method_exists($value, "toArray")) {
                $value = $value->toArray();
            }

            $results[$key] = $value;
        }

        return $results;
    }

    /**
     * Performs a merge recursively
     *
     * @param array $source
     * @param array $target
     *
     * @return array
     */
    final protected function internalMerge(array $source, array $target): array
    {
        foreach ($target as $key => $value) {
            if (is_array($value) &&
                true === isset($source[$key]) &&
                is_array($source[$key])) {
                $source[$key] = $this->internalMerge($source[$key], $value);
            } elseif (is_int($key)) {
                $source[] = $value;
            } else {
                $source[$key] = $value;
            }
        }

        return $source;
    }

    /**
     * Sets the collection data
     *
     * @param mixed $element
     * @param mixed $value
     */
    protected function setData($element, $value): void
    {
        $element = (string) $element;
        $key     = ($this->insensitive) ? mb_strtolower($element) : $element;

        $this->lowerKeys[$key] = $element;

        if (is_array($value)) {
            $data = new Config($value);
        } else {
            $data = $value;
        }

        $this->data[$element] = $data;
    }
}

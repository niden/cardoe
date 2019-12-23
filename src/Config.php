<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon;

use Phalcon\Config\Exception;

use function array_shift;
use function explode;
use function is_array;
use function is_int;
use function is_object;
use function method_exists;

/**
 * Class Config
 *
 * @property string|null $pathDelimiter
 */
class Config extends Collection
{
    public const DEFAULT_PATH_DELIMITER = ".";

    /**
     * @var string|null
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
     * @param array|object|Config $toMerge
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
     * @param mixed|null  $defaultValue
     * @param string|null $delimiter
     *
     * @return mixed|null
     */
    public function path(string $path, $defaultValue = null, string $delimiter = null)
    {
        if ($this->has($path)) {
            return $this->get($path);
        }

        $delimiter = $this->checkDelimiter($delimiter);
        $keys      = explode($delimiter, $path);
        $config    = clone $this;

        while (!empty($keys)) {
            $key = array_shift($keys);

            if (!$config->has($key)) {
                break;
            }

            if (empty($keys)) {
                return $config->get($key);
            }

            $config = $config->get($key);
            if (empty($config)) {
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
            if (
                is_object($value) &&
                method_exists($value, "toArray")
            ) {
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
            if (
                is_array($value) &&
                isset($source[$key]) &&
                is_array($source[$key])
            ) {
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

    /**
     * @param mixed $delimiter
     *
     * @return string
     */
    private function checkDelimiter($delimiter): string
    {
        if (empty($delimiter)) {
            return $this->getPathDelimiter();
        }

        return $delimiter;
    }
}

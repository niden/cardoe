<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Query
 * @license https://github.com/atlasphp/Atlas.Qyert/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\DM\Query;

use PDO;

/**
 * Class Bind
 *
 * @property int   $inlineCount
 * @property array $store
 */
class Bind
{
    /**
     * @var int
     */
    protected $inlineCount = 0;

    /**
     * @var array
     */
    protected $store = [];

    /**
     * @param mixed $value
     * @param int   $type
     *
     * @return string
     */
    public function inline($value, int $type = -1): string
    {
        if ($value instanceof Select) {
            return "(" . $value->getStatement() . ")";
        }

        if (is_array($value)) {
            return $this->inlineArray($value, $type);
        }

        $this->inlineCount++;
        $key = "__" . $this->inlineCount . "__";
        $this->setValue($key, $value, $type);

        return ":" . $key;
    }

    /**
     * Removes a value from the store
     *
     * @param string $key
     */
    public function remove(string $key)
    {
        unset($this->store[$key]);
    }

    /**
     * Sets a value
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $type
     */
    public function setValue(string $key, $value, int $type = -1): void
    {
        if ($type === -1) {
            $type = $this->getType($value);
        }

        $this->store[$key] = [$value, $type];
    }

    /**
     * Sets values from an array
     *
     * @param array $values
     * @param int   $type
     */
    public function setValues(array $values, int $type = -1): void
    {
        foreach ($values as $key => $value) {
            $this->setValue($key, $value, $type);
        }
    }

    /**
     * Returns the internal collection
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->store;
    }

    /**
     * Auto detects the PDO type
     *
     * @param mixed $value
     *
     * @return int
     */
    protected function getType($value)
    {
        if (is_null($value)) {
            return PDO::PARAM_NULL;
        }

        if (is_bool($value)) {
            return PDO::PARAM_BOOL;
        }

        if (is_int($value)) {
            return PDO::PARAM_INT;
        }

        return PDO::PARAM_STR;
    }

    /**
     * Processes an array - if passed as an `inline` parameter
     *
     * @param array $array
     * @param int   $type
     *
     * @return string
     */
    protected function inlineArray(array $array, int $type): string
    {
        $keys = [];
        foreach ($array as $value) {
            $this->inlineCount++;
            $key = "__" . $this->inlineCount . "__";
            $this->setValue($key, $value, $type);
            $keys[] = ":{$key}";
        }

        return "(" . implode(", ", $keys) . ")";
    }
}

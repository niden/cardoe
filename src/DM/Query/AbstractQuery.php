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
use Phalcon\DM\Pdo\Connection;

use function array_keys;
use function get_class_methods;
use function implode;
use function is_array;
use function is_bool;
use function is_int;
use function is_null;
use function ltrim;
use function substr;
use function ucfirst;
use function var_dump;

use const PHP_EOL;

/**
 * Class AbstractQuery
 *
 * @property Bind       $bind
 * @property Connection $connection
 * @property array      $store
 */
abstract class AbstractQuery
{
    /**
     * @var Bind
     */
    protected $bind;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $store = [];

    /**
     * AbstractQuery constructor.
     *
     * @param Connection $connection
     * @param Bind       $bind
     */
    public function __construct(Connection $connection, Bind $bind)
    {
        $this->bind       = $bind;
        $this->connection = $connection;
        $this->store["UNION"] = [];

        $this->reset();
    }

    /**
     * Binds a value inline
     *
     * @param mixed $value
     * @param int   $type
     *
     * @return string
     */
    public function bindInline($value, int $type = -1): string
    {
        return $this->bind->inline($value, $type);
    }

    /**
     * Binds a value - auto-detects the type if necessary
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $type
     *
     * @return AbstractQuery
     */
    public function bindValue(
        string $key,
        $value,
        int $type = -1
    ): AbstractQuery {
        $this->bind->setValue($key, $value, $type);

        return $this;
    }

    /**
     * Binds an array of values
     *
     * @param array $values
     *
     * @return AbstractQuery
     */
    public function bindValues(array $values): AbstractQuery
    {
        $this->bind->setValues($values);

        return $this;
    }

    /**
     * Returns all the bound values
     *
     * @return array
     */
    public function getBindValues(): array
    {
        return $this->bind->toArray();
    }

    abstract public function getStatement(): string;

    public function perform()
    {
        return $this->connection->perform(
            $this->getStatement(),
            $this->getBindValues()
        );
    }

    /**
     * Sets a flag for the query such as "DISTINCT"
     *
     * @param string $flag
     * @param bool   $enable
     */
    public function setFlag(string $flag, bool $enable = true): void
    {
        if ($enable) {
            $this->store["FLAGS"][$flag] = true;
        } else {
            unset($this->store["FLAGS"][$flag]);
        }
    }

    public function quoteIdentifier(string $name): string
    {
        return $this->connection->quoteName($name);
    }

    /**
     * Resets the internal array
     */
    public function reset()
    {
        $this->store["COLUMNS"] = [];
        $this->store["FLAGS"]   = [];
        $this->store["FROM"]    = [];
        $this->store["GROUP"]   = [];
        $this->store["HAVING"]  = [];
        $this->store["LIMIT"]   = 0;
        $this->store["ORDER"]   = [];
        $this->store["OFFSET"]  = 0;
        $this->store["WHERE"]   = [];

        foreach (get_class_methods($this) as $method) {
            if (substr($method, 0, 5) == 'reset' && $method != 'reset') {
                $this->$method();
            }
        }
    }

    /**
     * Builds the flags statement(s)
     *
     * @return string
     */
    protected function buildFlags()
    {
        if (empty($this->store["FLAGS"])) {
            return "";
        }

        return " " . implode(" ", array_keys($this->store["FLAGS"]));
    }

    /**
     * Indents a collection
     *
     * @param array  $collection
     * @param string $glue
     *
     * @return string
     */
    protected function indent(array $collection, string $glue = ""): string
    {
        if (empty($collection)) {
            return "";
        }

        return " " . implode($glue . " ", $collection);
    }
}

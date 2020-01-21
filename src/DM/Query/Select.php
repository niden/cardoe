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

use BadMethodCallException;
use PDO;

use function array_merge;
use function array_shift;
use function call_user_func_array;
use function end;
use function func_get_args;
use function is_array;
use function is_numeric;
use function is_string;
use function key;
use function ltrim;
use function strtoupper;
use function substr;
use function trim;

use const PHP_EOL;

/**
 * Class Select
 *
 * @property string $as
 * @property bool   $forUpdate
 *
 * @method int    fetchAffected()
 * @method array  fetchAll()
 * @method array  fetchAssoc()
 * @method array  fetchColumn(int $column = 0)
 * @method array  fetchGroup(int $flags = PDO::FETCH_ASSOC)
 * @method object fetchObject(string $class = 'stdClass', array $arguments = [])
 * @method array  fetchObjects(string $class = 'stdClass', array $arguments = [])
 * @method array  fetchOne()
 * @method array  fetchPairs()
 * @method mixed  fetchValue()
 */
class Select extends AbstractQuery
{
    public const JOIN_INNER   = "INNER";
    public const JOIN_LEFT    = "LEFT";
    public const JOIN_NATURAL = "NATURAL";
    public const JOIN_RIGHT   = "RIGHT";

    /**
     * @var string
     */
    protected $as = "";

    /**
     * @var bool
     */
    protected $forUpdate = false;

    /**
     * Proxied methods to the connection
     *
     * @param string $method
     * @param array  $params
     *
     * @return mixed
     */
    public function __call(string $method, array $params)
    {
        $proxied = [
            "fetchAffected" => true,
            "fetchAll"      => true,
            "fetchAssoc"    => true,
            "fetchCol"      => true,
            "fetchGroup"    => true,
            "fetchObject"   => true,
            "fetchObjects"  => true,
            "fetchOne"      => true,
            "fetchPairs"    => true,
            "fetchValue"    => true,
        ];

        if (isset($proxied[$method])) {
            return call_user_func_array(
                [
                    $this->connection,
                    $method,
                ],
                array_merge(
                    [
                        $this->getStatement(),
                        $this->getBindValues(),
                    ],
                    $params
                )
            );
        }

        throw new BadMethodCallException(
            "Unknown method: [" . $method . "]"
        );
    }

    /**
     * Sets a `AND` for a `HAVING` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function andHaving(string $condition, $value = null, int $type = -1): Select
    {
        $this->having($condition, $value, $type);

        return $this;
    }

    /**
     * Sets a `AND` for a `WHERE` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function andWhere(string $condition, $value = null, int $type = -1): Select
    {
        $this->where($condition, $value, $type);

        return $this;
    }

    /**
     * The `AS` statement for the query - useful in sub-queries
     *
     * @param string $as
     *
     * @return Select
     */
    public function as(string $as): Select
    {
        $this->as = $as;

        return $this;
    }

    /**
     * Concatenates to the most recent `HAVING` clause
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function catHaving(string $condition, $value = null, int $type = -1): Select
    {
        $this->catCondition("HAVING", $condition, $value, $type);

        return $this;
    }

    /**
     * Concatenates to the most recent `JOIN` clause
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function catJoin(string $condition, $value = null, int $type = -1): Select
    {
        if (!empty($value)) {
            $condition .= $this->bind->inline($value, $type);
        }

        end($this->store["FROM"]);
        $end = key($this->store["FROM"]);
        end($this->store["FROM"][$end]);

        $key = key($this->store["FROM"][$end]);

        $this->store["FROM"][$end][$key] .= $condition;

        return $this;
    }

    /**
     * Concatenates to the most recent `WHERE` clause
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function catWhere(string $condition, $value = null, int $type = -1): Select
    {
        $this->catCondition("WHERE", $condition, $value, $type);

        return $this;
    }

    /**
     * The columns to select from. If a key is set in an array element, the
     * key will be used as the alias
     *
     * @param string ...$column
     *
     * @return $this
     */
    public function columns()
    {
        $this->store['COLUMNS'] = array_merge(
            $this->store["COLUMNS"],
            func_get_args()
        );

        return $this;
    }

    /**
     * @param bool $enable
     *
     * @return Select
     */
    public function distinct(bool $enable = true): Select
    {
        $this->setFlag("DISTINCT", $enable);

        return $this;
    }

    /**
     * Enable the `FOR UPDATE` for the query
     *
     * @param bool $enable
     *
     * @return Select
     */
    public function forUpdate(bool $enable = true): Select
    {
        $this->forUpdate = $enable;

        return $this;
    }

    /**
     * Adds table(s) in the query
     *
     * @param array|string $table
     *
     * @return Select
     */
    public function from(string $table): Select
    {
        $this->store["FROM"][] = [$table];

        return $this;
    }

    /**
     * Returns the compiled SQL statement
     *
     * @return string
     */
    public function getStatement(): string
    {
        return implode("", $this->store["UNION"]) . $this->getCurrentStatement();
    }

    /**
     * Sets the `GROUP BY`
     *
     * @param array|string $groupBy
     *
     * @return Select
     */
    public function groupBy($groupBy): Select
    {
        $this->processValue("GROUP", $groupBy);

        return $this;
    }

    /**
     * Whether the query has columns or not
     *
     * @return bool
     */
    public function hasColumns()
    {
        return count($this->store["COLUMNS"]) > 0;
    }

    /**
     * Sets a `HAVING` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function having(string $condition, $value = null, int $type = -1): Select
    {
        $this->appendCondition("HAVING", "AND ", $condition, $value, $type);

        return $this;
    }

    /**
     * Sets a 'JOIN' condition
     *
     * @param string     $join
     * @param string     $table
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function join(
        string $join,
        string $table,
        string $condition = '',
        $value = null,
        $type = -1
    ): Select {
        $join = strtoupper(trim($join));
        if (substr($join, -4) != "JOIN") {
            $join .= " JOIN";
        }

        $condition = ltrim($condition);

        if (
            "" !== $condition
            && strtoupper(substr($condition, 0, 3)) !== "ON "
            && strtoupper(substr($condition, 0, 6)) !== "USING "
        ) {
            $condition = "ON " . $condition;
        }

        if (!empty($value)) {
            $condition .= $this->bind->inline($value, $type);
        }

        end($this->store["FROM"]);
        $end = key($this->store["FROM"]);

        $this->store["FROM"][$end][] = $join . " " . $table . " " . $condition;

        return $this;
    }

    /**
     * Sets the `LIMIT` clause
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit(int $limit): Select
    {
        $this->store["LIMIT"] = $limit;

        return $this;
    }

    /**
     * Sets the `OFFSET` clause
     *
     * @param int $offset
     *
     * @return $this
     */
    public function offset(int $offset): Select
    {
        $this->store["OFFSET"] = $offset;

        return $this;
    }

    /**
     * Sets the `ORDER BY`
     *
     * @param array|string $orderBy
     *
     * @return Select
     */
    public function orderBy($orderBy): Select
    {
        $this->processValue("ORDER", $orderBy);

        return $this;
    }

    /**
     * Sets a `OR` for a `HAVING` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function orHaving(string $condition, $value = null, int $type = -1): Select
    {
        $this->appendCondition("HAVING", "OR ", $condition, $value, $type);

        return $this;
    }

    /**
     * Sets a `OR` for a `WHERE` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function orWhere(string $condition, $value = null, int $type = -1): Select
    {
        $this->appendCondition("WHERE", "OR ", $condition, $value, $type);

        return $this;
    }

    /**
     * Resets the internal collections
     *
     * @return Select
     */
    public function reset(): Select
    {
        parent::reset();

        $this->as        = "";
        $this->forUpdate = false;

        return $this;
    }

    /**
     * Start a sub-select
     *
     * @return Select
     */
    public function subSelect(): Select
    {
        return new Select($this->connection, $this->bind);
    }

    /**
     * Start a `UNION`
     *
     * @return Select
     */
    public function union(): Select
    {
        $this->store["UNION"][] = $this->getCurrentStatement(" UNION ");

        $this->reset();

        return $this;
    }

    /**
     * Start a `UNION ALL`
     *
     * @return Select
     */
    public function unionAll(): Select
    {
        $this->store["UNION"][] = $this->getCurrentStatement(
            " UNION ALL "
        );

        $this->reset();

        return $this;
    }

    /**
     * Sets a `WHERE` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return Select
     */
    public function where(string $condition, $value = null, int $type = -1): Select
    {
        $this->appendCondition("WHERE", "AND ", $condition, $value, $type);

        return $this;
    }


    public function whereEquals(array $columnsValues)
    {
        foreach ($columnsValues as $key => $val) {
            if (is_numeric($key)) {
                $this->where($val);
            } elseif ($val === null) {
                $this->where($key . " IS NULL");
            } elseif (is_array($val)) {
                $this->where($key . " IN ", $val);
            } else {
                $this->where($key . " = ", $val);
            }
        }

        return $this;
    }

    /**
     * Statement builder
     *
     * @param string $suffix
     *
     * @return string
     */
    protected function getCurrentStatement(string $suffix = ''): string
    {
        $stm = 'SELECT'
            . $this->buildFlags()
            . $this->buildLimitEarly()
            . $this->buildColumns()
            . $this->buildFrom()
            . $this->buildCondition("WHERE")
            . $this->buildBy("GROUP")
            . $this->buildCondition("HAVING")
            . $this->buildBy("ORDER")
            . $this->buildLimit()
            . ($this->forUpdate ? " FOR UPDATE" : "")
        ;

        if ("" !== $this->as) {
            $stm = "(" . $stm . ") AS " . $this->as;
        }

        return $stm . $suffix;
    }

    /**
     * Appends a conditional
     *
     * @param string     $store
     * @param string     $andor
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     */
    protected function appendCondition(
        string $store,
        string $andor,
        string $condition,
        $value = null,
        $type = -1
    ): void {
        if (!empty($value)) {
            $condition .= $this->bindInline($value, $type);
        }

        if (empty($this->store[$store])) {
            $andor = "";
        }

        $this->store[$store][] = $andor . $condition;
    }

    /**
     * Builds a `BY` list
     *
     * @param string $type
     *
     * @return string
     */
    private function buildBy(string $type): string
    {
        if (empty($this->store[$type])) {
            return "";
        }

        return " " . $type . " BY"
            . $this->indent($this->store[$type], ",");
    }

    /**
     * Builds the columns list
     *
     * @return string
     */
    private function buildColumns(): string
    {
        if (!$this->hasColumns()) {
            $columns = ["*"];
        } else {
            $columns = $this->store['COLUMNS'];
        }

        return $this->indent($columns, ",");
    }

    /**
     * Builds the conditional string
     *
     * @param string $type
     *
     * @return string
     */
    private function buildCondition(string $type): string
    {
        if (empty($this->store[$type])) {
            return "";
        }

        return " " . $type
            . $this->indent($this->store[$type]);
    }

    /**
     * Builds the from list
     *
     * @return string
     */
    private function buildFrom(): string
    {
        if (empty($this->store["FROM"])) {
            return "";
        }

        $from = [];
        foreach ($this->store["FROM"] as $table) {
            $from[] = array_shift($table) . $this->indent($table);
        }

        return " FROM" . $this->indent($from, ",");
    }

    /**
     * Builds the early `LIMIT` clause - MS SQLServer
     *
     * @return string
     */
    private function buildLimitEarly(): string
    {
        $limit = "";
        if ("sqlsrv" === $this->connection->getDriverName()) {
            if ($this->store["LIMIT"] > 0 && 0 === $this->store["OFFSET"]) {
                $limit = " TOP " . $this->store["LIMIT"];
            }
        }

        return $limit;
    }

    /**
     * Builds the `LIMIT` clause
     *
     * @return string
     */
    private function buildLimit(): string
    {
        $limit = "";
        if ("sqlsrv" === $this->connection->getDriverName()) {
            if ($this->store["LIMIT"] > 0 && $this->store["OFFSET"] > 0) {
                $limit = " OFFSET " . $this->store["OFFSET"] . " ROWS"
                    . " FETCH NEXT " . $this->store["LIMIT"] . " ROWS ONLY";
            }
        } else {
            if (0 !== $this->store["LIMIT"]) {
                $limit .= "LIMIT " . $this->store["LIMIT"];
            }

            if (0 !== $this->store["OFFSET"]) {
                $limit .= " OFFSET " . $this->store["OFFSET"];
            }

            if ("" !== $limit) {
                $limit = " " . ltrim($limit);
            }
        }

        return $limit;
    }

    /**
     * Concatenates a conditional
     *
     * @param string $store
     * @param string $condition
     * @param mixed  $value
     * @param int    $type
     */
    protected function catCondition(
        string $store,
        string $condition,
        $value = null,
        int $type = -1
    ): void {
        if (!empty($value)) {
            $condition .= $this->bindInline($value, $type);
        }

        if (empty($this->store[$store])) {
            $this->store[$store][] = "";
        }

        end($this->store[$store]);
        $key = key($this->store[$store]);

        $this->store[$store][$key] .= $condition;
    }

    /**
     * Processes a value (array or string) and merges it with the store
     *
     * @param string       $store
     * @param array|string $data
     */
    private function processValue(string $store, $data): void
    {
        if (is_string($data)) {
            $data = [$data];
        }

        if (is_array($data)) {
            $this->store[$store] = array_merge(
                $this->store[$store],
                $data
            );
        }
    }
}

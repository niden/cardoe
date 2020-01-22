<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 */

declare(strict_types=1);

namespace Phalcon\DM\Query;

use Phalcon\DM\Pdo\Connection;

use function array_merge;
use function func_get_args;
use function var_dump;

/**
 * Class Update
 */
class Update extends AbstractConditions
{
    /**
     * Update constructor.
     *
     * @param Connection $connection
     * @param Bind       $bind
     */
    public function __construct(Connection $connection, Bind $bind)
    {
        parent::__construct($connection, $bind);

        $this->store["FROM"]      = "";
        $this->store["RETURNING"] = [];
    }

    /**
     * Sets a column for the `UPDATE` query
     *
     * @param string $column
     *
     * @return $this
     */
    public function column(string $column)
    {
        $arguments = func_get_args();
        $this->store["COLUMNS"][$column] = ":" . $column;

        if (isset($arguments[1]) && !empty($arguments[1])) {
            $value = $arguments[1];
            $type  = $arguments[2] ?? -1;
            $this->bind->setValue($column, $value, $type);
        }

        return $this;
    }

    /**
     * Mass sets columns and values for the `UPDATE`
     * @param array $columns
     *
     * @return $this
     */
    public function columns(array $columns)
    {
        foreach ($columns as $column => $value) {
            if (is_int($column)) {
                $this->column($value);
            } else {
                $this->column($column, $value);
            }
        }
        return $this;
    }

    /**
     * Adds table(s) in the query
     *
     * @param string $table
     *
     * @return Update
     */
    public function from(string $table): Update
    {
        $this->store["FROM"] = $table;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatement(): string
    {
        return "UPDATE"
            . $this->buildFlags()
            . " " . $this->store["FROM"]
            . $this->buildColumns()
            . $this->buildCondition("WHERE")
            . $this->buildReturning();
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
     * Adds the `RETURNING` clause
     *
     * @param string ...$columns
     *
     * @return Update
     */
    public function returning(): Update
    {
        $this->store["RETURNING"] = array_merge(
            $this->store["RETURNING"],
            func_get_args()
        );

        return $this;
    }

    /**
     * Resets the internal store
     */
    public function reset()
    {
        parent::reset();

        $this->store["FROM"]      = "";
        $this->store["RETURNING"] = [];
    }

    /**
     * Sets a column = value condition
     * @param string     $column
     * @param mixed|null $value
     *
     * @return Update
     */
    public function set(string $column, $value = null): Update
    {
        if (null === $value) {
            $value = "NULL";
        }

        $this->store["COLUMNS"][$column] = $value;
        $this->bind->remove($column);

        return $this;
    }

    /**
     * Builds the column list
     *
     * @return string
     */
    private function buildColumns(): string
    {
        $assignments = [];
        foreach ($this->store["COLUMNS"] as $column => $value) {
            $assignments[] = $this->quoteIdentifier($column) . " = " . $value;
        }

        return " SET" . $this->indent($assignments, ",");
    }
}

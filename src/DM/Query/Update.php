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
use const PHP_EOL;

class Update extends AbstractConditions
{
    /**
     * Delete constructor.
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
     * The columns to select from. If a key is set in an array element, the
     * key will be used as the alias
     *
     * @param string ...$column
     *
     * @return Update
     */
    public function columns(): Update
    {
        $this->store['COLUMNS'] = array_merge(
            $this->store["COLUMNS"],
            func_get_args()
        );

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
     * @return string
     */
    public function getStatement(): string
    {
        return "UPDATE"
            . $this->buildFlags()
            . " " . $this->store["FROM"]
            . $this->buildColumns()
            . $this->buildCondition("WHERE")
            . $this->buildReturning()
        ;
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

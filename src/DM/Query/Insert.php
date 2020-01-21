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

use function array_values;

/**
 * Class Insert
 */
class Insert extends AbstractQuery
{
    /**
     * Adds table(s) in the query
     *
     * @param string $table
     *
     * @return Insert
     */
    public function from(string $table): Insert
    {
        $this->store["FROM"] = $table;

        return $this;
    }

    /**
     * Returns the id of the last inserted record
     *
     * @param string|null $name
     *
     * @return string
     */
    public function getLastInsertId(string $name = null)
    {
        return $this->connection->lastInsertId($name);
    }

    /**
     * @return string
     */
    public function getStatement(): string
    {
        return "INSERT"
            . $this->buildFlags()
            . " INTO " . $this->store["FROM"]
            . $this->buildColumns()
            . $this->buildReturning()
        ;
    }

    /**
     * Builds the column list
     *
     * @return string
     */
    private function buildColumns(): string
    {
        $columns = [];
        foreach ($this->store["COLUMNS"] as $column => $value) {
            $columns[] = $this->quoteIdentifier($column);
        }
        return "("
            . $this->indent($columns, ",")
            . ") VALUES ("
            . $this->indent(array_values($this->store["COLUMNS"]), ",")
            . ")";
    }
}

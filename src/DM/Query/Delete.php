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

class Delete extends AbstractConditions
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
     * Adds table(s) in the query
     *
     * @param string $table
     *
     * @return AbstractConditions
     */
    public function from(string $table): Delete
    {
        $this->store["FROM"] = $table;

        return $this;
    }

    /**
     * Adds the `RETURNING` clause
     *
     * @param string ...$columns
     *
     * @return Delete
     */
    public function returning(): Delete
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
        return "DELETE"
            . $this->buildFlags()
            . " FROM " . $this->store["FROM"]
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
}

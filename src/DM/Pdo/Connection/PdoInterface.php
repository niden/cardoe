<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\DM\Pdo\Connection;

use PDO;
use PDOStatement;

/**
 * An interface to the native PDO object.
 */
interface PdoInterface
{
    /**
     * Begins a transaction and turns off autocommit mode.
     *
     * @return bool True on success, false on failure.
     *
     * @see http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction(): bool;

    /**
     * Commits the existing transaction and restores autocommit mode.
     *
     * @return bool True on success, false on failure.
     *
     * @see http://php.net/manual/en/pdo.commit.php
     */
    public function commit(): bool;

    /**
     * Gets the most recent error code.
     *
     * @return string|null
     */
    public function errorCode(): ?string;

    /**
     * Gets the most recent error info.
     *
     * @return array
     */
    public function errorInfo(): array;

    /**
     * Executes an SQL statement and returns the number of affected rows.
     *
     * @param string $statement The SQL statement to prepare and execute.
     *
     * @return int The number of affected rows.
     *
     * @see http://php.net/manual/en/pdo.exec.php
     */
    public function exec(string $statement): int;

    /**
     * Retrieve a database connection attribute
     *
     * @param int $attribute
     *
     * @return mixed
     */
    public function getAttribute(string $attribute);

    /**
     * Return an array of available PDO drivers
     *
     * @return array PDO::getAvailableDrivers returns an array of PDO driver
     *               names.If no drivers are available, it returns an empty array.
     *
     * @see https://php.net/manual/en/pdo.getavailabledrivers.php
     */
    public static function getAvailableDrivers(): array;

    /**
     * Is a transaction currently active?
     *
     * @return bool
     *
     * @see http://php.net/manual/en/pdo.intransaction.php
     */
    public function inTransaction(): bool;

    /**
     * Returns the last inserted autoincrement sequence value.
     *
     * @param string $name The name of the sequence to check; typically needed
     *                     only for PostgreSQL, where it takes the form of
     *                     `<table>_<column>_seq`.
     *
     * @return string
     *
     * @see http://php.net/manual/en/pdo.lastinsertid.php
     */
    public function lastInsertId(string $name = null): string;

    /**
     * Prepares an SQL statement for execution.
     *
     * @param string $statement The SQL statement to prepare for execution.
     * @param array  $options   Set these attributes on the returned
     *                          PDOStatement.
     *
     * @return PDOStatement|false
     *
     * @see http://php.net/manual/en/pdo.prepare.php
     */
    public function prepare(string $statement, array $options = []);

    /**
     * Queries the database and returns a PDOStatement.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param mixed  ...$fetch  Optional fetch-related parameters.
     *
     * @return PDOStatement|false
     *
     * @see http://php.net/manual/en/pdo.query.php
     */
    public function query(string $statement, ...$fetch);

    /**
     * Quotes a value for use in an SQL statement.
     *
     * This differs from `PDO::quote()` in that it will convert an array into
     * a string of comma-separated quoted values.
     *
     * @param mixed $value The value to quote.
     * @param int   $type  A data type hint for the database driver.
     *
     * @return string The quoted value.
     *
     * @see http://php.net/manual/en/pdo.quote.php
     */
    public function quote($value, int $type = PDO::PARAM_STR): string;

    /**
     * Rolls back the current transaction, and restores autocommit mode.
     *
     * @return bool True on success, false on failure.
     *
     * @see http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack(): bool;

    /**
     * Set a database connection attribute
     *
     * @param int   $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function setAttribute(int $attribute, $value): bool;
}

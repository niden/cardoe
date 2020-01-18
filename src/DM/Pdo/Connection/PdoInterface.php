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
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\DM\Pdo\Connection;

use PDO;
use PDOStatement;
use Phalcon\DM\Pdo\Exception\CannotBindValue;

/**
 * An interface to the native PDO object.
 */
interface PdoInterface
{
    /**
     * Begins a transaction. If the profiler is enabled, the operation will
     * be recorded.
     *
     * @return bool
     */
    public function beginTransaction(): bool;

    /**
     * Commits the existing transaction. If the profiler is enabled, the
     * operation will be recorded.
     *
     * @return bool
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
     * Executes an SQL statement and returns the number of affected rows. If
     * the profiler is enabled, the operation will be recorded.
     *
     * @param string $statement
     *
     * @return int
     */
    public function exec(string $statement): int;

    /**
     * Retrieve a database connection attribute
     *
     * @param int $attribute
     *
     * @return mixed
     */
    public function getAttribute($attribute);

    /**
     * Return an array of available PDO drivers (empty array if none available)
     *
     * @return array
     */
    public static function getAvailableDrivers(): array;

    /**
     * Is a transaction currently active? If the profiler is enabled, the
     * operation will be recorded. If the profiler is enabled, the operation
     * will be recorded.
     *
     * @return bool
     */
    public function inTransaction(): bool;

    /**
     * Returns the last inserted autoincrement sequence value. If the profiler
     * is enabled, the operation will be recorded.
     *
     * @param string $name
     *
     * @return string
     */
    public function lastInsertId(string $name = null): string;

    /**
     * Prepares an SQL statement for execution.
     *
     * @param string $statement
     * @param array  $options
     *
     * @return PDOStatement|false
     */
    public function prepare($statement, array $options = []);

    /**
     * Prepares an SQL statement with bound values. The method only binds values
     * that have associated placeholders in the statement. It also binds
     * sequential (question-mark) placeholders. If a placeholder is an array, it
     * is converted to a comma separated string to be used with a `IN`
     * condition.
     *
     * @param string $statement
     * @param array  $values
     *
     * @return PDOStatement|false
     * @throws CannotBindValue
     */
    public function prepareWithValues(
        string $statement,
        array $values = []
    ): PDOStatement;

    /**
     * Queries the database and returns a PDOStatement. If the profiler is
     * enabled, the operation will be recorded.
     *
     * @param string $statement
     * @param mixed  ...$fetch
     *
     * @return PDOStatement|false
     */
    public function query(string $statement, ...$fetch);

    /**
     * Quotes a value for use in an SQL statement. This differs from
     * `PDO::quote()` in that it will convert an array into a string of
     * comma-separated quoted values. The default type is `PDO::PARAM_STR`
     *
     * @param mixed $value
     * @param int   $type
     *
     * @return string The quoted value.
     */
    public function quote($value, int $type = PDO::PARAM_STR): string;

    /**
     * Quotes a multi-part (dotted) identifier name.
     *
     * @param string $name
     *
     * @return string
     */
    public function quoteName(string $name): string;

    /**
     * Quotes a single identifier name.
     *
     * @param string $name
     *
     * @return string
     */
    public function quoteSingleName(string $name): string;

    /**
     * Rolls back the current transaction, and restores autocommit mode. If the
     * profiler is enabled, the operation will be recorded.
     *
     * @return bool
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

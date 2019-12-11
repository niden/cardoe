<?php

/**
 * This file is part of the Cardoe Framework.
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

namespace Cardoe\DM\Pdo;

use BadMethodCallException;
use Cardoe\DM\Pdo\Parser\ParserInterface;
use Cardoe\DM\Pdo\Profiler\ProfilerInterface;
use PDO;
use PDOStatement;

/**
 * Provides array quoting, profiling, a new `perform()` method, new `fetch*()`
 * methods
 *
 * @property array             $args
 * @property ParserInterface   $parser
 * @property PDO               $pdo
 * @property ProfilerInterface $profiler
 * @property string            $quoteNameEscapeFind
 * @property string            $quoteNamePrefix
 * @property string            $quoteNameEscapeRepl
 * @property string            $quoteNameSuffix
 */
interface ConnectionInterface
{
    /**
     *
     * Constructor.
     *
     * This overrides the parent so that it can take connection attributes as a
     * constructor parameter, and set them after connection.
     *
     * @param string            $dsn      The data source name for the
     *                                    connection.
     * @param string            $username The username for the connection.
     * @param string            $password The password for the connection.
     * @param array             $options  Driver-specific options for the
     *                                    connection.
     * @param array             $queries  Queries to execute after the
     *                                    connection.
     * @param ProfilerInterface $profiler Tracks and logs query profiles.
     *
     * @see http://php.net/manual/en/pdo.construct.php
     *
     */
    public function __construct(
        string $dsn,
        string $username = null,
        string $password = null,
        array $options = [],
        array $queries = [],
        ProfilerInterface $profiler = null
    );

    /**
     *
     * Proxies to PDO methods created for specific drivers; in particular,
     * `sqlite` and `pgsql`.
     *
     * @param string $name      The PDO method to call; e.g.
     *                          `sqliteCreateFunction` or `pgsqlGetPid`.
     * @param array  $arguments Arguments to pass to the called method.
     *
     * @return mixed
     * @throws BadMethodCallException when the method does not exist.
     *
     */
    public function __call($name, array $arguments);

    /**
     * The purpose of this method is to hide sensitive data from stack traces.
     *
     * @return array
     */
    public function __debugInfo();

    /**
     * Begins a transaction and turns off autocommit mode.
     *
     * @return bool True on success, false on failure.
     *
     * @see http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction(): bool;

    /**
     *
     * Commits the existing transaction and restores autocommit mode.
     *
     * @return bool True on success, false on failure.
     *
     * @see http://php.net/manual/en/pdo.commit.php
     *
     */
    public function commit(): bool;

    /**
     * Connects to the database.
     */
    public function connect(): void;

    /**
     * Disconnects from the database.
     */
    public function disconnect(): void;

    /**
     * Gets the most recent error code.
     *
     * @return mixed
     */
    public function errorCode();

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
     * Performs a statement and returns the number of affected rows.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return int
     * @throws Exception\CannotBindValue
     */
    public function fetchAffected(string $statement, array $values = []): int;

    /**
     * Fetches a sequential array of rows from the database; the rows
     * are returned as associative arrays.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return array
     * @throws Exception\CannotBindValue
     */
    public function fetchAll(string $statement, array $values = []): array;

    /**
     *
     * Fetches an associative array of rows from the database; the rows
     * are returned as associative arrays, and the array of rows is keyed
     * on the first column of each row.
     *
     * N.b.: If multiple rows have the same first column value, the last
     * row with that value will override earlier rows.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return array
     * @throws Exception\CannotBindValue
     */
    public function fetchAssoc(string $statement, array $values = []): array;

    /**
     * Fetches the first column of rows as a sequential array.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return array
     * @throws Exception\CannotBindValue
     */
    public function fetchCol(string $statement, array $values = []): array;

    /**
     * Fetches multiple from the database as an associative array. The first
     * column will be the index key.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     * @param int    $style     a fetch style defaults to PDO::FETCH_COLUMN for
     *                          single values, use PDO::FETCH_NAMED when
     *                          fetching a multiple columns
     *
     * @return array
     * @throws Exception\CannotBindValue
     */
    public function fetchGroup(
        string $statement,
        array $values = [],
        int $style = PDO::FETCH_COLUMN
    ): array;

    /**
     * Fetches one row from the database as an object where the column values
     * are mapped to object properties.
     *
     * Warning: PDO "injects property-values BEFORE invoking the constructor -
     * in other words, if your class initializes property-values to defaults
     * in the constructor, you will be overwriting the values injected by
     * fetchObject() !"
     *
     * <http://www.php.net/manual/en/pdostatement.fetchobject.php#111744>
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     * @param string $class     The name of the class to create.
     * @param array  $args      Arguments to pass to the object constructor.
     *
     * @return object
     * @throws Exception\CannotBindValue
     */
    public function fetchObject(
        string $statement,
        array $values = [],
        string $class = 'stdClass',
        array $args = []
    ): object;

    /**
     * Fetches a sequential array of rows from the database; the rows
     * are returned as objects where the column values are mapped to
     * object properties.
     *
     * Warning: PDO "injects property-values BEFORE invoking the constructor -
     * in other words, if your class initializes property-values to defaults
     * in the constructor, you will be overwriting the values injected by
     * fetchObject() !"
     *
     * <http://www.php.net/manual/en/pdostatement.fetchobject.php#111744>
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     * @param string $class     The name of the class to create from each row.
     * @param array  $args      Arguments to pass to each object constructor.
     *
     * @return array
     * @throws Exception\CannotBindValue
     */
    public function fetchObjects(
        string $statement,
        array $values = [],
        string $class = 'stdClass',
        array $args = []
    ): array;

    /**
     * Fetches one row from the database as an associative array.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return array
     * @throws Exception\CannotBindValue
     */
    public function fetchOne(string $statement, array $values = []): array;

    /**
     * Fetches an associative array of rows as key-value pairs (first
     * column is the key, second column is the value).
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return array
     * @throws Exception\CannotBindValue
     */
    public function fetchPairs(string $statement, array $values = []): array;

    /**
     * Fetches the very first value (i.e., first column of the first row).
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return mixed
     * @throws Exception\CannotBindValue
     */
    public function fetchValue(string $statement, array $values = []);

    /**
     * Retrieve a database connection attribute
     *
     * @param int $attribute
     *
     * @return mixed
     */
    public function getAttribute(int $attribute);

    /**
     * Returns the Parser instance.
     *
     * @return ParserInterface
     */
    public function getParser(): ParserInterface;

    /**
     * Return the inner PDO (if any)
     *
     * @return PDO
     */
    public function getAdapter(): PDO;

    /**
     * Returns the Profiler instance.
     *
     * @return ProfilerInterface
     */
    public function getProfiler(): ProfilerInterface;

    /**
     * Is a transaction currently active?
     *
     * @return bool
     *
     * @see http://php.net/manual/en/pdo.intransaction.php
     */
    public function inTransaction(): bool;

    /**
     * Is the PDO connection active?
     *
     * @return bool
     */
    public function isConnected(): bool;

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
     * Performs a query with bound values and returns the resulting
     * PDOStatement; array values will be passed through `quote()` and their
     * respective placeholders will be replaced in the query string.
     *
     * @param string $statement The SQL statement to perform.
     * @param array  $values    Values to bind to the query
     *
     * @return PDOStatement
     * @throws Exception\CannotBindValue
     *
     * @see quote()
     */
    public function perform(string $statement, array $values = []): PDOStatement;

    /**
     * Prepares an SQL statement for execution.
     *
     * @param string $statement The SQL statement to prepare for execution.
     * @param array  $options   Set these attributes on the returned
     *                          PDOStatement.
     *
     * @return PDOStatement
     *
     * @see http://php.net/manual/en/pdo.prepare.php
     */
    public function prepare(string $statement, array $options = []): PDOStatement;

    /**
     * Prepares an SQL statement with bound values.
     *
     * This method only binds values that have placeholders in the
     * statement, thereby avoiding errors from PDO regarding too many bound
     * values. It also binds all sequential (question-mark) placeholders.
     *
     * If a placeholder value is an array, the array is converted to a string
     * of comma-separated quoted values; e.g., for an `IN (...)` condition.
     * The quoted string is replaced directly into the statement instead of
     * using `PDOStatement::bindValue()` proper.
     *
     * @param string $statement The SQL statement to prepare for execution.
     * @param array  $values    The values to bind to the statement, if any.
     *
     * @return PDOStatement
     * @throws Exception\CannotBindValue
     *
     * @see http://php.net/manual/en/pdo.prepare.php
     */
    public function prepareWithValues(string $statement, array $values = []): PDOStatement;

    /**
     *
     * Queries the database and returns a PDOStatement.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param mixed  ...$fetch  Optional fetch-related parameters.
     *
     * @return PDOStatement
     *
     * @see http://php.net/manual/en/pdo.query.php
     */
    public function query(string $statement, ...$fetch): PDOStatement;

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
     * Quotes a multi-part (dotted) identifier name.
     *
     * @param string $name The multi-part identifier name.
     *
     * @return string The multi-part identifier name, quoted.
     */
    public function quoteName(string $name): string;

    /**
     * Quotes a single identifier name.
     *
     * @param string $name The identifier name.
     *
     * @return string The quoted identifier name.
     */
    public function quoteSingleName(string $name): string;

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

    /**
     * Sets the Parser instance.
     *
     * @param ParserInterface $parser The Parser instance.
     *
     * @return Connection
     */
    public function setParser(ParserInterface $parser): Connection;

    /**
     * Sets the Profiler instance.
     *
     * @param ProfilerInterface $profiler The Profiler instance.
     *
     * @return Connection
     */
    public function setProfiler(ProfilerInterface $profiler): Connection;
}

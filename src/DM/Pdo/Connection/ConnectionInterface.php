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

namespace Cardoe\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Exception\CannotBindValue;
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
interface ConnectionInterface extends PdoInterface
{
    /**
     * Connects to the database.
     */
    public function connect(): void;

    /**
     * Disconnects from the database.
     */
    public function disconnect(): void;

    /**
     * Performs a statement and returns the number of affected rows.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return int
     * @throws CannotBindValue
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
     * @throws CannotBindValue
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
     * @throws CannotBindValue
     */
    public function fetchAssoc(string $statement, array $values = []): array;

    /**
     * Fetches the first column of rows as a sequential array.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return array
     * @throws CannotBindValue
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
     * @throws CannotBindValue
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
     * @throws CannotBindValue
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
     * @throws CannotBindValue
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
     * @throws CannotBindValue
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
     * @throws CannotBindValue
     */
    public function fetchPairs(string $statement, array $values = []): array;

    /**
     * Fetches the very first value (i.e., first column of the first row).
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return mixed
     * @throws CannotBindValue
     */
    public function fetchValue(string $statement, array $values = []);

    /**
     * Return the inner PDO (if any)
     *
     * @return PDO
     */
    public function getAdapter(): PDO;

    /**
     * Returns the Parser instance.
     *
     * @return ParserInterface
     */
    public function getParser(): ParserInterface;

    /**
     * Returns the Profiler instance.
     *
     * @return ProfilerInterface
     */
    public function getProfiler(): ProfilerInterface;

    /**
     * Is the PDO connection active?
     *
     * @return bool
     */
    public function isConnected(): bool;

    /**
     * Performs a query with bound values and returns the resulting
     * PDOStatement; array values will be passed through `quote()` and their
     * respective placeholders will be replaced in the query string.
     *
     * @param string $statement The SQL statement to perform.
     * @param array  $values    Values to bind to the query
     *
     * @return PDOStatement
     * @throws CannotBindValue
     *
     * @see quote()
     */
    public function perform(string $statement, array $values = []): PDOStatement;

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
     * @throws CannotBindValue
     *
     * @see http://php.net/manual/en/pdo.prepare.php
     */
    public function prepareWithValues(string $statement, array $values = []): PDOStatement;

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
     * Sets the Parser instance.
     *
     * @param ParserInterface $parser The Parser instance.
     */
    public function setParser(ParserInterface $parser);

    /**
     * Sets the Profiler instance.
     *
     * @param ProfilerInterface $profiler The Profiler instance.
     */
    public function setProfiler(ProfilerInterface $profiler);
}

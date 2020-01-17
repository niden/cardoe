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

use BadMethodCallException;
use Phalcon\DM\Pdo\Exception\CannotBindValue;
use Phalcon\DM\Pdo\Parser\ParserInterface;
use Phalcon\DM\Pdo\Parser\SqliteParser;
use Phalcon\DM\Pdo\Profiler\ProfilerInterface;
use PDO;
use PDOStatement;

use function call_user_func_array;
use function is_array;

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
abstract class AbstractConnection implements ConnectionInterface
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @var string
     */
    protected $quoteNameEscapeFind = '"';

    /**
     * @var string
     */
    protected $quoteNamePrefix = '"';

    /**
     * @var string
     */
    protected $quoteNameEscapeRepl = '""';

    /**
     * @var string
     */
    protected $quoteNameSuffix = '"';

    /**
     * Proxies to PDO methods created for specific drivers; in particular,
     * `sqlite` and `pgsql`.
     *
     * @param string $name      The PDO method to call; e.g.
     *                          `sqliteCreateFunction` or `pgsqlGetPid`.
     * @param array  $arguments Arguments to pass to the called method.
     *
     * @return mixed
     * @throws BadMethodCallException when the method does not exist.
     */
    public function __call($name, array $arguments)
    {
        $this->connect();

        if (!method_exists($this->pdo, $name)) {
            $class   = get_class($this);
            $message = "Class '{$class}' does not have a method '{$name}'";
            throw new BadMethodCallException($message);
        }

        return call_user_func_array([$this->pdo, $name], $arguments);
    }

    /**
     * Begins a transaction and turns off autocommit mode.
     *
     * @return bool True on success, false on failure.
     *
     * @see http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction(): bool
    {
        $this->connect();
        $this->profiler->start(__FUNCTION__);
        $result = $this->pdo->beginTransaction();
        $this->profiler->finish();

        return $result;
    }

    /**
     * Commits the existing transaction and restores autocommit mode.
     *
     * @return bool True on success, false on failure.
     *
     * @see http://php.net/manual/en/pdo.commit.php
     */
    public function commit(): bool
    {
        $this->connect();
        $this->profiler->start(__FUNCTION__);
        $result = $this->pdo->commit();
        $this->profiler->finish();

        return $result;
    }

    /**
     * Connects to the database.
     */
    abstract public function connect(): void;

    /**
     * Disconnects from the database.
     */
    abstract public function disconnect(): void;

    /**
     * Gets the most recent error code.
     *
     * @return string|null
     */
    public function errorCode(): ?string
    {
        $this->connect();

        return $this->pdo->errorCode();
    }

    /**
     * Gets the most recent error info.
     *
     * @return array
     */
    public function errorInfo(): array
    {
        $this->connect();

        return $this->pdo->errorInfo();
    }

    /**
     * Executes an SQL statement and returns the number of affected rows.
     *
     * @param string $statement The SQL statement to prepare and execute.
     *
     * @return int The number of affected rows.
     *
     * @see http://php.net/manual/en/pdo.exec.php
     */
    public function exec(string $statement): int
    {
        $this->connect();
        $this->profiler->start(__FUNCTION__);
        $affectedRows = $this->pdo->exec($statement);
        $this->profiler->finish($statement);

        return $affectedRows;
    }

    /**
     * Performs a statement and returns the number of affected rows.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return int
     * @throws CannotBindValue
     */
    public function fetchAffected(string $statement, array $values = []): int
    {
        $sth = $this->perform($statement, $values);

        return $sth->rowCount();
    }

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
    public function fetchAll(string $statement, array $values = []): array
    {
        return $this->fetchData(
            "fetchAll",
            [PDO::FETCH_ASSOC],
            $statement,
            $values
        );
    }

    /**
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
    public function fetchAssoc(string $statement, array $values = []): array
    {
        $sth  = $this->perform($statement, $values);
        $data = [];
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $data[current($row)] = $row;
        }

        return $data;
    }

    /**
     * Fetches the first column of rows as a sequential array.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return array
     * @throws CannotBindValue
     */
    public function fetchCol(string $statement, array $values = []): array
    {
        return $this->fetchData(
            "fetchAll",
            [PDO::FETCH_COLUMN, 0],
            $statement,
            $values
        );
    }

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
        int $style = PDO::FETCH_ASSOC
    ): array {
        return $this->fetchData(
            "fetchAll",
            [PDO::FETCH_GROUP | $style],
            $statement,
            $values
        );
    }

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
    ): object {
        $sth = $this->perform($statement, $values);

        return $sth->fetchObject($class, $args);
    }

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
    ): array {
        $sth = $this->perform($statement, $values);

        return $sth->fetchAll(PDO::FETCH_CLASS, $class, $args);
    }

    /**
     * Fetches one row from the database as an associative array.
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return array
     * @throws CannotBindValue
     */
    public function fetchOne(string $statement, array $values = []): array
    {
        return $this->fetchData(
            "fetch",
            [PDO::FETCH_ASSOC],
            $statement,
            $values
        );
    }

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
    public function fetchPairs(string $statement, array $values = []): array
    {
        return $this->fetchData(
            "fetchAll",
            [PDO::FETCH_KEY_PAIR],
            $statement,
            $values
        );
    }

    /**
     * Fetches the very first value (i.e., first column of the first row).
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @param array  $values    Values to bind to the query.
     *
     * @return mixed
     * @throws CannotBindValue
     */
    public function fetchValue(string $statement, array $values = [])
    {
        $sth = $this->perform($statement, $values);

        return $sth->fetchColumn(0);
    }

    /**
     * Return the inner PDO (if any)
     *
     * @return PDO
     */
    public function getAdapter(): PDO
    {
        $this->connect();

        return $this->pdo;
    }

    /**
     * Retrieve a database connection attribute
     *
     * @param int $attribute
     *
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        $this->connect();

        return $this->pdo->getAttribute($attribute);
    }

    /**
     * Return an array of available PDO drivers
     *
     * @return array PDO::getAvailableDrivers returns an array of PDO driver
     *               names.If no drivers are available, it returns an empty array.
     *
     * @see https://php.net/manual/en/pdo.getavailabledrivers.php
     */
    public static function getAvailableDrivers(): array
    {
        return PDO::getAvailableDrivers();
    }

    /**
     * Return the driver name
     *
     * @return string
     */
    public function getDriverName(): string
    {
        $this->connect();

        return $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    }
    
    /**
     * Returns the Parser instance.
     *
     * @return ParserInterface
     */
    public function getParser(): ParserInterface
    {
        return $this->parser;
    }

    /**
     * Returns the Profiler instance.
     *
     * @return ProfilerInterface
     */
    public function getProfiler(): ProfilerInterface
    {
        return $this->profiler;
    }

    /**
     * Is a transaction currently active?
     *
     * @return bool
     *
     * @see http://php.net/manual/en/pdo.intransaction.php
     */
    public function inTransaction(): bool
    {
        $this->connect();
        $this->profiler->start(__FUNCTION__);
        $result = $this->pdo->inTransaction();
        $this->profiler->finish();
        return $result;
    }

    /**
     * Is the PDO connection active?
     *
     * @return bool
     */
    public function isConnected(): bool
    {
        return (bool) $this->pdo;
    }

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
    public function lastInsertId(string $name = null): string
    {
        $this->connect();

        $this->profiler->start(__FUNCTION__);
        $result = $this->pdo->lastInsertId($name);
        $this->profiler->finish();

        return $result;
    }

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
    public function perform(string $statement, array $values = []): PDOStatement
    {
        $this->connect();

        $sth = $this->prepareWithValues($statement, $values);
        $this->profiler->start(__FUNCTION__);
        $sth->execute();
        $this->profiler->finish($statement, $values);

        return $sth;
    }

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
    public function prepare($statement, array $options = [])
    {
        $this->connect();

        return $this->pdo->prepare($statement, $options);
    }

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
     * @return PDOStatement|false
     * @throws CannotBindValue
     *
     * @see http://php.net/manual/en/pdo.prepare.php
     */
    public function prepareWithValues(string $statement, array $values = []): PDOStatement
    {
        // if there are no values to bind ...
        if (empty($values)) {
            // ... use the normal preparation
            return $this->prepare($statement);
        }

        $this->connect();

        // rebuild the statement and values
        $parser = clone $this->parser;
        [$statement, $values] = $parser->rebuild($statement, $values);

        // prepare the statement
        $sth = $this->pdo->prepare($statement);

        // for the placeholders we found, bind the corresponding data values
        foreach ($values as $key => $val) {
            $this->bindValue($sth, $key, $val);
        }

        // done
        return $sth;
    }

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
    public function query(string $statement, ...$fetch)
    {
        $this->connect();

        $this->profiler->start(__FUNCTION__);
        $sth = $this->pdo->query($statement, ...$fetch);
        $this->profiler->finish($sth->queryString);

        return $sth;
    }

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
    public function quote($value, int $type = PDO::PARAM_STR): string
    {
        $this->connect();

        // non-array quoting
        if (!is_array($value)) {
            return $this->pdo->quote((string) $value, $type);
        }

        // quote array values, not keys, then combine with commas
        foreach ($value as $key => $element) {
            $value[$key] = $this->pdo->quote((string) $element, $type);
        }

        return implode(', ', $value);
    }

    /**
     * Quotes a multi-part (dotted) identifier name.
     *
     * @param string $name The multi-part identifier name.
     *
     * @return string The multi-part identifier name, quoted.
     */
    public function quoteName(string $name): string
    {
        if (strpos($name, '.') === false) {
            return $this->quoteSingleName($name);
        }

        return implode(
            '.',
            array_map(
                [$this, 'quoteSingleName'],
                explode('.', $name)
            )
        );
    }

    /**
     * Quotes a single identifier name.
     *
     * @param string $name The identifier name.
     *
     * @return string The quoted identifier name.
     */
    public function quoteSingleName(string $name): string
    {
        $name = str_replace(
            $this->quoteNameEscapeFind,
            $this->quoteNameEscapeRepl,
            $name
        );

        return $this->quoteNamePrefix
            . $name
            . $this->quoteNameSuffix;
    }

    /**
     * Rolls back the current transaction, and restores autocommit mode.
     *
     * @return bool True on success, false on failure.
     *
     * @see http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack(): bool
    {
        $this->connect();

        $this->profiler->start(__FUNCTION__);
        $result = $this->pdo->rollBack();
        $this->profiler->finish();

        return $result;
    }

    /**
     * Set a database connection attribute
     *
     * @param int   $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function setAttribute(int $attribute, $value): bool
    {
        $this->connect();

        return $this->pdo->setAttribute($attribute, $value);
    }

    /**
     * Sets the Parser instance.
     *
     * @param ParserInterface $parser The Parser instance.
     */
    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Sets the Profiler instance.
     *
     * @param ProfilerInterface $profiler The Profiler instance.
     */
    public function setProfiler(ProfilerInterface $profiler)
    {
        $this->profiler = $profiler;
    }

    /**
     * Bind a value using the proper PDO::PARAM_* type.
     *
     * @param PDOStatement $sth The statement to bind to.
     * @param mixed        $key The placeholder key.
     * @param mixed        $val The value to bind to the statement.
     *
     * @return bool
     * @throws CannotBindValue when the value to be bound is not
     * bindable (e.g., array, object, or resource).
     */
    protected function bindValue(PDOStatement $sth, $key, $val): bool
    {
        if (is_int($val)) {
            return $sth->bindValue($key, $val, PDO::PARAM_INT);
        }

        if (is_bool($val)) {
            return $sth->bindValue($key, $val, PDO::PARAM_BOOL);
        }

        if (is_null($val)) {
            return $sth->bindValue($key, $val, PDO::PARAM_NULL);
        }

        if (!is_scalar($val)) {
            $type = gettype($val);
            throw new CannotBindValue(
                "Cannot bind value of type '{$type}' to placeholder '{$key}'"
            );
        }

        return $sth->bindValue($key, $val);
    }

    /**
     * @param string $method
     * @param array  $arguments
     * @param string $statement
     * @param array  $values
     *
     * @return array
     * @throws CannotBindValue
     */
    protected function fetchData(
        string $method,
        array $arguments,
        string $statement,
        array $values = []
    ) {
        $sth    = $this->perform($statement, $values);
        $result = call_user_func_array([$sth, $method], $arguments);

        /**
         * If this returns boolean or anything other than an array, return
         * an empty array back
         */
        if (!is_array($result)) {
            $result = [];
        }

        return $result;
    }

    /**
     * Returns a new Parser instance.
     *
     * @param string $driver Return a parser for this driver.
     *
     * @return ParserInterface
     */
    protected function newParser(string $driver): ParserInterface
    {
        $class = sprintf("Phalcon\DM\Pdo\Parser\%sParser", ucfirst($driver));
        if (!class_exists($class)) {
            $class = SqliteParser::class;
        }

        return new $class();
    }

    /**
     * Sets quoting properties based on the PDO driver.
     *
     * @param string $driver The PDO driver name.
     */
    protected function setQuoteName(string $driver)
    {
        switch ($driver) {
            case 'mysql':
                $this->quoteNamePrefix     = '`';
                $this->quoteNameSuffix     = '`';
                $this->quoteNameEscapeFind = '`';
                $this->quoteNameEscapeRepl = '``';
                break;

            case 'sqlsrv':
                $this->quoteNamePrefix     = '[';
                $this->quoteNameSuffix     = ']';
                $this->quoteNameEscapeFind = ']';
                $this->quoteNameEscapeRepl = '][';
                break;

            default:
                $this->quoteNamePrefix     = '"';
                $this->quoteNameSuffix     = '"';
                $this->quoteNameEscapeFind = '"';
                $this->quoteNameEscapeRepl = '""';
                break;
        }
    }
}

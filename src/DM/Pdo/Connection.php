<?php

declare(strict_types=1);

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

namespace Cardoe\DM\Pdo;

use Cardoe\Logger\Exception;
use PDO;
use PDORow;
use PDOStatement;
use Psr\Log\LoggerInterface;
use function is_array;
use function is_bool;
use function is_int;
use function microtime;
use function var_dump;
use const PHP_EOL;

/**
 * Decorator for PDO instances.
 *
 * @property bool            $collectQueries
 * @property LoggerInterface $logger
 * @property bool            $logQueries
 * @property PDO             $pdo
 * @property array           $queries
 */
class Connection
{
    /**
     * @var bool
     */
    protected $collectQueries = false;

    /**
     * @var LoggerInterface
     */
    protected $logger = null;

    /**
     * @var string
     */
    protected $logFormat = '';

    /**
     * @var bool
     */
    protected $logQueries = false;

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var array
     */
    protected $queries = [];

    /**
     * Connection constructor.
     *
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array  $options
     */
    public function __construct(
        string $dsn,
        string $username = '',
        string $password = '',
        array $options = []
    ) {

        if (true !== isset($options[PDO::ATTR_ERRMODE])) {
            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        }

        $this->logFormat = '[A: %start%][Z: %start%][D: %duration%]'
            . '[S: %statement%][V: %values%]' . PHP_EOL . '[Trace: %trace%]';

        $this->pdo = new PDO($dsn, $username, $password, $options);
    }

    /**
     * Begins a transaction
     *
     * @return bool
     */
    public function beginTransaction(): bool
    {
        $entry  = $this->newLogEntry(__METHOD__);
        $result = $this->pdo->beginTransaction();
        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Commits a transaction
     *
     * @return bool
     */
    public function commit(): bool
    {
        $entry  = $this->newLogEntry(__METHOD__);
        $result = $this->pdo->commit();
        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Enables collecting queries
     *
     * @param bool $enable
     *
     * @return Connection
     */
    public function enableCollect(bool $enable): Connection
    {
        $this->collectQueries = $enable;

        return $this;
    }

    /**
     * Enables logging queries
     *
     * @param bool $enable
     *
     * @return Connection
     */
    public function enableLogging(bool $enable): Connection
    {
        $this->logQueries = $enable;

        return $this;
    }

    /**
     * Executes a PDO statement
     *
     * @param string $statement
     *
     * @return int
     */
    public function exec(string $statement): int
    {
        $entry    = $this->newLogEntry($statement);
        $rowCount = $this->pdo->exec($statement);
        $this->addLogEntry($entry);

        return $rowCount;
    }

    /**
     * Returns the affected rows
     *
     * @param string $statement
     * @param array  $values
     *
     * @return int
     */
    public function fetchAffected(
        string $statement,
        array $values = []
    ): int {
        $entry  = $this->newLogEntry(__METHOD__);
        $sth    = $this->perform($statement, $values);
        $result = $sth->rowCount();

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Fetches all the data with FETCH_ASSOC
     *
     * @param string $statement
     * @param array  $values
     *
     * @return array
     */
    public function fetchAll(
        string $statement,
        array $values = []
    ): array {
        $entry  = $this->newLogEntry(__METHOD__);
        $result = $this->performFetch(PDO::FETCH_ASSOC, $statement, $values);

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Fetches all the data using FETCH_COLUMN
     *
     * @param string $statement
     * @param array  $values
     * @param int    $column
     *
     * @return array
     */
    public function fetchColumn(
        string $statement,
        array $values = [],
        int $column = 0
    ): array {
        $entry  = $this->newLogEntry(__METHOD__);
        $sth    = $this->perform($statement, $values);
        $result = $sth->fetchAll(PDO::FETCH_COLUMN, $column);

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Fetches all the data with FETCH_GROUP
     *
     * @param string $statement
     * @param array  $values
     * @param int    $style
     *
     * @return array
     */
    public function fetchGroup(
        string $statement,
        array $values = [],
        int $style = PDO::FETCH_ASSOC
    ): array {
        $entry  = $this->newLogEntry(__METHOD__);
        $result = $this->performFetch(
            PDO::FETCH_GROUP | $style,
            $statement,
            $values
        );

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Fetches all the data with FETCH_KEY_PAIR
     *
     * @param string $statement
     * @param array  $values
     *
     * @return array
     */
    public function fetchKeyPair(
        string $statement,
        array $values = []
    ): array {
        $entry  = $this->newLogEntry(__METHOD__);
        $result = $this->performFetch(PDO::FETCH_KEY_PAIR, $statement, $values);

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Fetches a record and returns it as an object
     *
     * @param string $statement
     * @param array  $values
     * @param string $class
     * @param array  $ctorArgs
     *
     * @return mixed
     */
    public function fetchObject(
        string $statement,
        array $values = [],
        string $class = 'stdClass',
        array $ctorArgs = []
    ) {
        $entry = $this->newLogEntry(__METHOD__);
        $sth   = $this->perform($statement, $values);

        if (true !== empty($ctorArgs)) {
            $result = $sth->fetchObject($class, $ctorArgs);
        } else {
            $result = $sth->fetchObject($class);
        }

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Fetches all the data using FETCH_CLASS
     *
     * @param string $statement
     * @param array  $values
     * @param string $class
     * @param array  $ctorArgs
     *
     * @return array
     */
    public function fetchObjects(
        string $statement,
        array $values = [],
        string $class = 'stdClass',
        array $ctorArgs = []
    ): array {
        $entry = $this->newLogEntry(__METHOD__);
        $sth   = $this->perform($statement, $values);

        if (true !== empty($ctorArgs)) {
            $result = $sth->fetchAll(PDO::FETCH_CLASS, $class, $ctorArgs);
        } else {
            $result = $sth->fetchAll(PDO::FETCH_CLASS, $class);
        }

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Fetches one record
     *
     * @param string $statement
     * @param array  $values
     *
     * @return array|null
     */
    public function fetchOne(
        string $statement,
        array $values = []
    ): ?array {
        $entry = $this->newLogEntry(__METHOD__);
        $sth   = $this->perform($statement, $values);

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        $this->addLogEntry($entry);

        if ($result === false) {
            return null;
        }

        return $result;
    }

    /**
     * Fetches all the data with FETCH_UNIQUE
     *
     * @param string $statement
     * @param array  $values
     * @param int    $style
     *
     * @return array
     */
    public function fetchUnique(
        string $statement,
        array $values = [],
        int $style = PDO::FETCH_ASSOC
    ): array {
        $entry  = $this->newLogEntry(__METHOD__);
        $result = $this->performFetch(
            PDO::FETCH_UNIQUE | $style,
            $statement,
            $values
        );

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Fetches a value from a column
     *
     * @param string $statement
     * @param array  $values
     * @param int    $column
     *
     * @return mixed
     */
    public function fetchValue(
        string $statement,
        array $values = [],
        int $column = 0
    ) {
        $entry  = $this->newLogEntry(__METHOD__);
        $sth    = $this->perform($statement, $values);
        $result = $sth->fetchColumn($column);

        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Returns teh driver name
     *
     * @return string
     */
    public function getDriverName(): string
    {
        return $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    }

    /**
     * Returns the log format
     *
     * @return string
     */
    public function getLogFormat(): string
    {
        return $this->logFormat;
    }

    /**
     * Returns the PDO instance
     *
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Returns any collected queries
     *
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * Prepares a statement and executes it, binding any values
     *
     * @param string $statement
     * @param array  $values
     *
     * @return PDOStatement
     */
    public function perform(
        string $statement,
        array $values = []
    ): PDOStatement {
        $sth = $this->pdo->prepare($statement);

        foreach ($values as $name => $args) {
            $this->performBind($sth, $name, $args);
        }

        $sth->execute();

        return $sth;
    }

    /**
     * Execute a query
     *
     * @param string $statement
     * @param mixed  ...$fetch
     *
     * @return PDOStatement
     */
    public function query(string $statement, ...$fetch): PDOStatement
    {
        $entry = $this->newLogEntry($statement);
        $sth   = $this->pdo->query($statement, ...$fetch);
        $this->addLogEntry($entry);

        return $sth;
    }

    /**
     * Rolls back the transaction
     *
     * @return bool
     */
    public function rollBack(): bool
    {
        $entry  = $this->newLogEntry(__METHOD__);
        $result = $this->pdo->rollBack();
        $this->addLogEntry($entry);

        return $result;
    }

    /**
     * Sets the log format
     *
     * @param string $format
     *
     * @return Connection
     */
    public function setLogFormat(string $format): Connection
    {
        $this->logFormat = $format;

        return $this;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return Connection
     */
    public function setLogger(LoggerInterface $logger): Connection
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Adds a log entry if logging is enabled
     *
     * @param array $entry
     */
    protected function addLogEntry(array $entry): void
    {
        if (true === $this->logQueries && $this->logger instanceof LoggerInterface) {
            $entry['finish']   = microtime(true);
            $entry['duration'] = $entry['finish'] - $entry['start'];
            $entry['trace']    = (new Exception())->getTraceAsString();

            $this->logger->info($this->formatLogEntry($entry));
        }

        if (true === $this->collectQueries) {
            $this->queries[] = $entry;
        }
    }

    /**
     * Formats the log data
     *
     * @param array $entry
     *
     * @return string
     */
    protected function formatLogEntry(array $entry): string
    {
        return str_replace(
            [
                '%start%',
                '%finish%',
                '%duration%',
                '%statement%',
                '%values%',
                '%trace%',
            ],
            $entry,
            $this->logFormat
        );
    }

    /**
     * Creates a new log entry array
     *
     * @param string $statement
     * @param array  $values
     *
     * @return array
     */
    protected function newLogEntry(string $statement, array $values = []): array
    {
        if (true === $this->logQueries) {
            return [
                'start'     => microtime(true),
                'finish'    => null,
                'duration'  => null,
                'statement' => $statement,
                'values'    => $values,
                'trace'     => null,
            ];
        }

        return [];
    }

    /**
     * @param PDOStatement $sth
     * @param mixed        $name
     * @param mixed        $args
     */
    protected function performBind(PDOStatement $sth, $name, $args)
    {
        if (true === is_int($name)) {
            // sequential placeholders are 1-based
            $name++;
        }

        if (true !== is_array($args)) {
            $sth->bindValue($name, $args);
        } else {
            $type = $args[1] ?? PDO::PARAM_STR;

            if ($type === PDO::PARAM_BOOL && true === is_bool($args[0])) {
                $args[0] = $args[0] ? '1' : '0';
            }

            $sth->bindValue($name, ...$args);
        }
    }

    /**
     * Performs a fetchAll using a specific mode
     *
     * @param int    $mode
     * @param string $statement
     * @param array  $values
     *
     * @return array
     */
    private function performFetch(
        int $mode,
        string $statement,
        array $values = []
    ): array {
        $sth = $this->perform($statement, $values);

        return $sth->fetchAll($mode);
    }
}

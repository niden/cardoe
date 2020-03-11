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

namespace Phalcon\DataMapper\Pdo;

use InvalidArgumentException;
use PDO;
use Phalcon\DataMapper\Pdo\Connection\AbstractConnection;
use Phalcon\DataMapper\Pdo\Profiler\Profiler;
use Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface;

use function explode;

/**
 * Provides array quoting, profiling, a new `perform()` method, new `fetch*()`
 * methods
 *
 * @property array             $arguments
 * @property PDO               $pdo
 * @property ProfilerInterface $profiler
 */
class Connection extends AbstractConnection
{
    /**
     * @var array
     */
    protected array $arguments = [];

    /**
     * Constructor.
     *
     * This overrides the parent so that it can take connection attributes as a
     * constructor parameter, and set them after connection.
     *
     * @param string            $dsn
     * @param string            $username
     * @param string            $password
     * @param array             $options
     * @param array             $queries
     * @param ProfilerInterface $profiler
     */
    public function __construct(
        string $dsn,
        string $username = null,
        string $password = null,
        array $options = [],
        array $queries = [],
        ProfilerInterface $profiler = null
    ) {
        $parts     = explode(':', $dsn);
        $available = [
            "mysql"  => true,
            "pgsql"  => true,
            "sqlite" => true,
            "mssql"  => true,
        ];
        if (!isset($available[$parts[0]])) {
            throw new InvalidArgumentException(
                "Driver not supported [" . $parts[0] . "]"
            );
        }


        // if no error mode is specified, use exceptions
        if (!isset($options[PDO::ATTR_ERRMODE])) {
            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        }

        // Arguments store
        $this->arguments = [
            $dsn,
            $username,
            $password,
            $options,
            $queries,
        ];

        // Create a new profiler if none has been passed
        if ($profiler === null) {
            $profiler = new Profiler();
        }
        $this->setProfiler($profiler);

        // Quotes
        $this->quote = $this->getQuoteNames($parts[0]);
    }

    /**
     * The purpose of this method is to hide sensitive data from stack traces.
     *
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'arguments' => [
                $this->arguments[0],
                '****',
                '****',
                $this->arguments[3],
                $this->arguments[4],
            ],
        ];
    }

    /**
     * Connects to the database.
     */
    public function connect(): void
    {
        if (!$this->pdo) {
            // connect
            $this->profiler->start(__FUNCTION__);
            [$dsn, $username, $password, $options, $queries] = $this->arguments;
            $this->pdo = new PDO($dsn, $username, $password, $options);
            $this->profiler->finish();

            foreach ($queries as $query) {
                $this->exec($query);
            }
        }
    }

    /**
     * Disconnects from the database.
     */
    public function disconnect(): void
    {
        $this->profiler->start(__FUNCTION__);
        $this->pdo = null;
        $this->profiler->finish();
    }
}

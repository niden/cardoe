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

use Cardoe\DM\Pdo\Connection\AbstractConnection;
use Cardoe\DM\Pdo\Parser\ParserInterface;
use Cardoe\DM\Pdo\Profiler\Profiler;
use Cardoe\DM\Pdo\Profiler\ProfilerInterface;
use PDO;

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
class Connection extends AbstractConnection
{
    /**
     * @var array
     */
    protected $args = [];

    /**
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
     */
    public function __construct(
        string $dsn,
        string $username = null,
        string $password = null,
        array $options = [],
        array $queries = [],
        ProfilerInterface $profiler = null
    ) {
        // if no error mode is specified, use exceptions
        if (!isset($options[PDO::ATTR_ERRMODE])) {
            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        }

        // retain the arguments for later
        $this->args = [
            $dsn,
            $username,
            $password,
            $options,
            $queries,
        ];

        // retain a profiler, instantiating a default one if needed
        if ($profiler === null) {
            $profiler = new Profiler();
        }
        $this->setProfiler($profiler);

        // retain a query parser
        $parts  = explode(':', $dsn);
        $parser = $this->newParser($parts[0]);
        $this->setParser($parser);

        // set quotes for identifier names
        $this->setQuoteName($parts[0]);
    }

    /**
     * The purpose of this method is to hide sensitive data from stack traces.
     *
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'args' => [
                $this->args[0],
                '****',
                '****',
                $this->args[3],
                $this->args[4],
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
            [$dsn, $username, $password, $options, $queries] = $this->args;
            $this->pdo = new PDO($dsn, $username, $password, $options);
            $this->profiler->finish();

            // connection-time queries
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

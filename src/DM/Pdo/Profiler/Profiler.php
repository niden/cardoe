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

namespace Phalcon\DM\Pdo\Profiler;

use Phalcon\DM\Pdo\Exception\Exception;
use Phalcon\Helper\Json;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

use function json_encode;

/**
 * Sends query profiles to a logger.
 *
 * @property bool            $active
 * @property array           $context
 * @property string          $logFormat
 * @property string          $logLevel
 * @property LoggerInterface $logger
 */
class Profiler implements ProfilerInterface
{
    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var array
     */
    protected $context = [];

    /**
     * @var string
     */
    protected $logFormat = "{method} ({duration} seconds): {statement} {backtrace}";

    /**
     * @var string
     */
    protected $logLevel = LogLevel::DEBUG;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger Record profiles through this interface.
     */
    public function __construct(LoggerInterface $logger = null)
    {
        if ($logger === null) {
            $logger = new MemoryLogger();
        }

        $this->logger = $logger;
    }

    /**
     * Finishes and logs a profile entry.
     *
     * @param string $statement The statement being profiled, if any.
     * @param array  $values    The values bound to the statement, if any.
     */
    public function finish(string $statement = null, array $values = []): void
    {
        if ($this->active) {
            $finish = microtime(true);
            $ex     = new Exception();

            $this->context['backtrace'] = $ex->getTraceAsString();
            $this->context['duration']  = $finish - $this->context['start'];
            $this->context['finish']    = $finish;
            $this->context['statement'] = $statement;
            $this->context['values']    = empty($values) ? '' : Json::encode($values);

            $this->logger->log($this->logLevel, $this->logFormat, $this->context);

            $this->context = [];
        }
    }

    /**
     * Returns the log message format string, with placeholders.
     *
     * @return string
     */
    public function getLogFormat(): string
    {
        return $this->logFormat;
    }

    /**
     * Returns the underlying logger instance.
     *
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Returns the level at which to log profile messages.
     *
     * @return string
     */
    public function getLogLevel(): string
    {
        return $this->logLevel;
    }

    /**
     * Returns true if logging is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Enable or disable profiler logging.
     *
     * @param bool $active
     *
     * @return ProfilerInterface
     */
    public function setActive($active): ProfilerInterface
    {
        $this->active = (bool) $active;

        return $this;
    }

    /**
     * Sets the log message format string, with placeholders.
     *
     * @param string $logFormat
     *
     * @return ProfilerInterface
     */
    public function setLogFormat($logFormat): ProfilerInterface
    {
        $this->logFormat = $logFormat;

        return $this;
    }

    /**
     * Level at which to log profile messages.
     *
     * @param string $logLevel A PSR LogLevel constant.
     *
     * @return ProfilerInterface
     */
    public function setLogLevel($logLevel): ProfilerInterface
    {
        $this->logLevel = $logLevel;

        return $this;
    }

    /**
     * Starts a profile entry.
     *
     * @param string $method The method starting the profile entry.
     */
    public function start(string $method): void
    {
        if ($this->active) {
            $this->context = [
                "method" => $method,
                "start"  => microtime(true),
            ];
        }
    }
}

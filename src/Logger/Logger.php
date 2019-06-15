<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Logger;

use Cardoe\Helper\Arr;
use Cardoe\Logger\Adapter\AdapterInterface;
use Psr\Log\LoggerInterface;
use function array_keys;
use function var_dump;

/**
 * Class Logger
 *
 * @package Cardoe\Logger
 */
class Logger implements LoggerInterface
{
    const ALERT     = 2;
    const CRITICAL  = 1;
    const CUSTOM    = 8;
    const DEBUG     = 7;
    const EMERGENCY = 0;
    const ERROR     = 3;
    const INFO      = 6;
    const NOTICE    = 5;
    const WARNING   = 4;

    /**
     * The adapter stack
     *
     * @var AdapterInterface[]
     */
    protected $adapters = [];

    /**
     * @var string
     */
    protected $name = "";

    /**
     * The excluded adapters for this log process
     *
     * @var bool[]
     */
    protected $excluded = [];

    /**
     * Constructor.
     *
     * @param string $name     The name of the logger
     * @param array  $adapters The collection of adapters to be used for
     *                         logging (default [])
     */
    public function __construct(string $name, array $adapters = [])
    {
        $this->name = $name;

        $this->setAdapters($adapters);
    }

    /**
     * Add an adapter to the stack. For processing we use FIFO
     *
     * @param string           $name    The name of the adapter
     * @param AdapterInterface $adapter The adapter to add to the stack
     *
     * @return Logger
     */
    public function addAdapter(string $name, AdapterInterface $adapter): Logger
    {
        $this->adapters[$name] = $adapter;

        return $this;
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function alert($message, array $context = []): void
    {
        $this->addMessage(self::ALERT, (string) $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function critical($message, array $context = []): void
    {
        $this->addMessage(self::CRITICAL, (string) $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function debug($message, array $context = []): void
    {
        $this->addMessage(self::DEBUG, (string) $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function error($message, array $context = []): void
    {
        $this->addMessage(self::ERROR, (string) $message, $context);
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function emergency($message, array $context = []): void
    {
        $this->addMessage(self::EMERGENCY, (string) $message, $context);
    }

    /**
     * Exclude certain adapters.
     *
     * @param array $adapters
     *
     * @return Logger
     */
    public function excludeAdapters(array $adapters = []): Logger
    {
        /**
         * Loop through what has been passed. Check these names with
         * the registered adapters. If they match, add them to the
         * this->excluded array
         */
        $registered = $this->adapters;

        /**
         * Loop through what has been passed. Check these names with
         * the registered adapters. If they match, add them to the
         * this->excluded array
         */
        foreach ($adapters as $adapter) {
            if (true === isset($registered[$adapter])) {
                $this->excluded[$adapter] = true;
            }
        }
        return $this;
    }

    /**
     * Returns an adapter from the stack
     *
     * @param string $name The name of the adapter
     *
     * @return AdapterInterface
     * @throws Exception
     */
    public function getAdapter(string $name): AdapterInterface
    {
        if (true !== isset($this->adapters[$name])) {
            throw new Exception("Adapter does not exist for this logger");
        }

        return $this->adapters[$name];
    }

    /**
     * Returns the adapter stack array
     *
     * @return AdapterInterface[]
     */
    public function getAdapters(): array
    {
        return $this->adapters;
    }

    /**
     * Returns the name of the logger
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function info($message, array $context = []): void
    {
        $this->addMessage(self::INFO, (string) $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function log($level, $message, array $context = []): void
    {
        $intLevel = $this->getLevelNumber($level);

        $this->addMessage($intLevel, (string) $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function notice($message, array $context = []): void
    {
        $this->addMessage(self::NOTICE, (string) $message, $context);
    }

    /**
     * Removes an adapter from the stack
     *
     * @param string $name The name of the adapter
     *
     * @return Logger
     * @throws Exception
     */
    public function removeAdapter(string $name): Logger
    {
        if (true !== isset($this->adapters[$name])) {
            throw new Exception("Adapter does not exist for this logger");
        }

        unset($this->adapters[$name]);

        return $this;
    }

    /**
     * Sets the adapters stack overriding what is already there
     *
     * @param array $adapters An array of adapters
     *
     * @return Logger
     */
    public function setAdapters(array $adapters): Logger
    {
        $this->adapters = $adapters;

        return $this;
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function warning($message, array $context = []): void
    {
        $this->addMessage(self::WARNING, (string) $message, $context);
    }

    /**
     * Adds a message to each handler for processing
     *
     * @param int    $level
     * @param string $message
     * @param array  $context
     *
     * @return bool
     * @throws Exception
     */
    protected function addMessage(int $level, string $message, array $context = []): bool
    {
        if (count($this->adapters) === 0) {
            throw new Exception("No adapters specified");
        }

        $levels    = $this->getLevels();
        $levelName = Arr::get($levels, $level, self::CUSTOM);

        $item = new Item($message, $levelName, $level, time(), $context);

        /**
         * Log only if the key does not exist in the excluded ones
         */
        foreach ($this->adapters as $name => $adapter) {
            if (true !== isset($this->excluded[$name])) {
                $adapter->process($item);
            }
        }

        /**
         * Clear the excluded array since we made the call now
         */
        $this->excluded = [];

        return true;
    }

    /**
     * Returns an array of log levels with integer to string conversion
     */
    protected function getLevels(): array
    {
        return [
            self::ALERT     => "alert",
            self::CRITICAL  => "critical",
            self::DEBUG     => "debug",
            self::EMERGENCY => "emergency",
            self::ERROR     => "error",
            self::INFO      => "info",
            self::NOTICE    => "notice",
            self::WARNING   => "warning",
            self::CUSTOM    => "custom",
        ];
    }

    /**
     * Converts the level from string/word to an integer
     *
     * @param string|int $level
     *
     * @return int
     */
    private function getLevelNumber($level): int
    {
        if (true === is_string($level)) {
            $levelName = mb_strtolower($level);
            $levels    = array_flip($this->getLevels());

            if (true === isset($levels[$levelName])) {
                return $levels[$levelName];
            }
        } elseif (true === is_numeric($level)) {
            $levels = $this->getLevels();

            if (true === isset($levels[$level])) {
                return (int) $level;
            }
        }

        return self::CUSTOM;
    }
}

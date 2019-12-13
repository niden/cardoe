<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Logger\Adapter;

use Cardoe\Helper\Arr;
use Cardoe\Logger\Exception;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use LogicException;

use const LOG_ERR;
use const LOG_ODELAY;
use const LOG_USER;

/**
 * Class Syslog
 *
 * @package Cardoe\Logger\Adapter
 */
class Syslog extends AbstractAdapter
{
    /**
     * Name of the default formatter class
     *
     * @var string
     */
    protected $defaultFormatter = "Line";

    /**
     * @var int
     */
    protected $facility = 0;

    /**
     * @var string
     */
    protected $name = "";

    /**
     * @var bool
     */
    protected $opened = false;

    /**
     * @var int
     */
    protected $option = 0;

    /**
     * Syslog constructor.
     *
     * @param string $name
     * @param array  $options
     */
    public function __construct(string $name, array $options = [])
    {
        $this->name     = $name;
        $this->option   = Arr::get($options, "option", LOG_ODELAY);
        $this->facility = Arr::get($options, "facility", LOG_USER);
    }

    /**
     * Closes the logger
     */
    public function close(): bool
    {
        if (true !== $this->opened) {
            return true;
        }

        return closelog();
    }

    /**
     * Processes the message i.e. writes it to the syslog
     *
     * @param Item $item
     *
     * @throws Exception
     */
    public function process(Item $item): void
    {
        $formatter = $this->getFormatter();
        $message   = $formatter->format($item);
        $result    = openlog($this->name, $this->option, $this->facility);

        if (!$result) {
            throw new LogicException(
                sprintf(
                    "Cannot open syslog for name [%s] and facility [%s]",
                    $this->name,
                    (string) $this->facility
                )
            );
        }

        $this->opened = true;
        $level        = $this->logLevelToSyslog($message[1]);

        syslog($level, $message[1]);
    }

    /**
     * Translates a Logger level to a Syslog level
     *
     * @param string $level
     *
     * @return int
     */
    private function logLevelToSyslog(string $level): int
    {
        $levels = [
            Logger::ALERT     => LOG_ALERT,
            Logger::CRITICAL  => LOG_CRIT,
            Logger::CUSTOM    => LOG_ERR,
            Logger::DEBUG     => LOG_DEBUG,
            Logger::EMERGENCY => LOG_EMERG,
            Logger::ERROR     => LOG_ERR,
            Logger::INFO      => LOG_INFO,
            Logger::NOTICE    => LOG_NOTICE,
            Logger::WARNING   => LOG_WARNING,
        ];

        return Arr::get($levels, $level, LOG_ERR);
    }
}

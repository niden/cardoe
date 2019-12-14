<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Logger\Adapter;

use Phalcon\Helper\Arr;
use Phalcon\Logger\Exception;
use Phalcon\Logger\Item;
use Phalcon\Logger;
use LogicException;

use const LOG_ERR;
use const LOG_ODELAY;
use const LOG_USER;

/**
 * Class Syslog
 *
 * @property string $defaultFormatter
 * @property int    $facility
 * @property string $name
 * @property bool   $opened
 * @property int    $option
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
        $level        = $this->logLevelToSyslog($item->getType());

        syslog($level, $message);
    }

    /**
     * Translates a Logger level to a Syslog level
     *
     * @param int $level
     *
     * @return int
     */
    private function logLevelToSyslog(int $level): int
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

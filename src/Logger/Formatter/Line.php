<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Logger\Formatter;

use Cardoe\Logger\Item;

use function date;
use function is_array;
use function str_replace;
use function strpos;

use const PHP_EOL;

/**
 * Cardoe\Logger\Formatter\Line
 *
 * Formats messages using an one-line string
 */
class Line extends AbstractFormatter
{
    /**
     * Default date format
     *
     * @var string
     */
    protected $dateFormat;

    /**
     * Format applied to each message
     *
     * @var string
     */
    protected $format;

    /**
     * Line constructor.
     *
     * @param string $format
     * @param string $dateFormat
     */
    public function __construct(
        string $format = "[%date%][%type%] %message%",
        string $dateFormat = "D, d M y H:i:s O"
    ) {
        $this->format     = $format;
        $this->dateFormat = $dateFormat;
    }

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Applies a format to a message before sent it to the internal log
     *
     * @param Item $item
     *
     * @return string
     */
    public function format(Item $item): string
    {
        $format = $this->format;

        /**
         * Check if the format has the %date% placeholder
         */
        if (false !== strpos($format, "%date%")) {
            $format = str_replace(
                "%date%",
                date(
                    $this->dateFormat,
                    $item->getTime()
                ),
                $format
            );
        }

        /**
         * Check if the format has the %type% placeholder
         */
        if (false !== strpos($format, "%type%")) {
            $format = str_replace("%type%", $item->getName(), $format);
        }

        $format = str_replace("%message%", $item->getMessage(), $format) . PHP_EOL;

        if (is_array($item->getContext())) {
            return $this->interpolate(
                $format,
                $item->getContext()
            );
        }

        return $format;
    }

    /**
     * @param string $dateFormat
     *
     * @return Line
     */
    public function setDateFormat(string $dateFormat): Line
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }

    /**
     * @param string $format
     *
     * @return Line
     */
    public function setFormat(string $format): Line
    {
        $this->format = $format;

        return $this;
    }
}

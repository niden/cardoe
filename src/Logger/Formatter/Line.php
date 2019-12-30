<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Logger\Formatter;

use Exception;
use Phalcon\Logger\Item;

use function is_array;
use function str_replace;
use function strpos;

/**
 * Phalcon\Logger\Formatter\Line
 *
 * Formats messages using an one-line string
 *
 * @property string $dateFormat
 * @property string $format
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
        string $dateFormat = "c"
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
     * @throws Exception
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
                $this->getFormattedDate(),
                $format
            );
        }

        /**
         * Check if the format has the %type% placeholder
         */
        if (false !== strpos($format, "%type%")) {
            $format = str_replace("%type%", $item->getName(), $format);
        }

        $format = str_replace("%message%", $item->getMessage(), $format);

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

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
        string $format = "[{date}][{type}] {message}",
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
        return $this->getFormattedMessage($item);
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

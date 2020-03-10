<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Logger\Formatter;

use Exception;
use Phalcon\Helper\Str;
use Phalcon\Logger\Item;

use function str_replace;

/**
 * Class Line
 *
 * @property string $format
 */
class Line extends AbstractFormatter
{
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
        if (Str::includes($format, "%date%")) {
            $format = str_replace(
                "%date%",
                $this->getFormattedDate(),
                $format
            );
        }

        /**
         * Check if the format has the %type% placeholder
         */
        if (Str::includes($format, "%type%")) {
            $format = str_replace("%type%", $item->getName(), $format);
        }

        $format = str_replace("%message%", $item->getMessage(), $format);

        return $this->interpolate(
            $format,
            $item->getContext()
        );
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }
}

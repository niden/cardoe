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
use Phalcon\Helper\Json as JsonHelper;
use Phalcon\Logger\Item;

/**
 * Phalcon\Logger\Formatter\Json
 *
 * Formats messages using JSON encoding
 *
 * @property string $dateFormat
 */
class Json extends AbstractFormatter
{
    /**
     * Default date format
     *
     * @var string
     */
    protected $dateFormat;

    /**
     * Json constructor.
     *
     * @param string $dateFormat
     */
    public function __construct(string $dateFormat = "c")
    {
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
     * Applies a format to a message before sent it to the internal log
     *
     * @param Item $item
     *
     * @return string
     * @throws Exception
     */
    public function format(Item $item): string
    {
        if (null !== $item->getContext()) {
            $message = $this->interpolate(
                $item->getMessage(),
                $item->getContext()
            );
        } else {
            $message = $item->getMessage();
        }

        return JsonHelper::encode(
            [
                "type"      => $item->getName(),
                "message"   => $message,
                "timestamp" => $this->getFormattedDate(),
            ]
        );
    }

    /**
     * @param string $dateFormat
     *
     * @return Json
     */
    public function setDateFormat(string $dateFormat): Json
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }
}

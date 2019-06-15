<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Logger\Formatter;

use Cardoe\Logger\Item;
use function date;
use function is_array;
use function json_encode;
use const PHP_EOL;

/**
 * Cardoe\Logger\Formatter\Json
 *
 * Formats messages using JSON encoding
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
    public function __construct(string $dateFormat = "D, d M y H:i:s O")
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
     */
    public function format(Item $item): string
    {
        if (true === is_array($item->getContext())) {
            $message = $this->interpolate(
                $item->getMessage(),
                $item->getContext()
            );
        } else {
            $message = $item->getMessage();
        }

        return json_encode(
            [
                    "type"      => $item->getName(),
                    "message"   => $message,
                    "timestamp" => date($this->dateFormat, $item->getTime()),
                ]
        ) . PHP_EOL;
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

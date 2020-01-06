<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Logger\Formatter;

use DateTimeImmutable;
use DateTimeZone;
use Exception;

use Phalcon\Logger\Item;
use function is_array;

/**
 * Class AbstractFormatter
 *
 * @package Phalcon\Logger\Formatter
 */
abstract class AbstractFormatter implements FormatterInterface
{
    /**
     * Interpolates context values into the message placeholders
     *
     * @see http://www.php-fig.org/psr/psr-3/ Section 1.2 Message
     *
     * @param string $message
     * @param array  $context
     *
     * @return string
     */
    public function interpolate(string $message, $context = []): string
    {
        if (!empty($context) > 0) {
            $replace = [];
            foreach ($context as $key => $value) {
                $replace["{" . $key . "}"] = $value;
            }

            return strtr($message, $replace);
        }

        return $message;
    }

    /**
     * Returns the date formatted for the logger.
     *
     * @return string
     * @throws Exception
     * @todo Not using the set time from the Item since we have interface
     *       misalignment which will break semver This will change in the future
     *
     */
    protected function getFormattedDate(): string
    {
        $timezone = date_default_timezone_get();
        $date     = new DateTimeImmutable("now", new DateTimeZone($timezone));

        return $date->format($this->dateFormat);
    }

    /**
     * @param Item $item
     *
     * @return string
     * @throws Exception
     */
    protected function getFormattedMessage(Item $item): string
    {
        $context = [
            'date'    => $this->getFormattedDate(),
            'type'    => $item->getName(),
            'message' => $this->interpolate(
                $item->getMessage(),
                $item->getContext()
            ),
        ];
        $context = array_merge($item->getContext(), $context);

        return $this->interpolate($this->format, $context);
    }
}

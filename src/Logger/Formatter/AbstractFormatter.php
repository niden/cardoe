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

use DateTimeImmutable;
use DateTimeZone;
use Exception;

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
}

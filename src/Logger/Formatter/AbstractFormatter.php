<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Logger\Formatter;

use function is_array;

/**
 * Class AbstractFormatter
 *
 * @package Cardoe\Logger\Formatter
 */
abstract class AbstractFormatter implements FormatterInterface
{
    /**
     * Interpolates context values into the message placeholders
     *
     * @see http://www.php-fig.org/psr/psr-3/ Section 1.2 Message
     *
     * @param string     $message
     * @param array|null $context
     *
     * @return string
     */
    public function interpolate(string $message, $context = null): string
    {
        if (true === is_array($context) && count($context) > 0) {
            $replace = [];
            foreach ($context as $key => $value) {
                $replace["{" . $key . "}"] = $value;
            }

            return strtr($message, $replace);
        }

        return $message;
    }
}

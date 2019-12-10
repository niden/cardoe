<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Helper;

use function base64_decode;
use function base64_encode;
use function str_repeat;
use function str_replace;
use function strlen;

/**
 * Cardoe\Helper\Base64
 *
 * This class offers quick string base64 functions
 */
class Base64
{
    /**
     * Encode a json string in Base64 Url format.
     *
     * @param string $input
     *
     * @return string
     */
    final public static function encodeUrl(string $input): string
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * Decode a Base64 Url string to a json string
     *
     * @param string $input
     *
     * @return string
     */
    final public static function decodeUrl(string $input): string
    {
        if ($remainder = strlen($input) % 4) {
            $input .= str_repeat("=", 4 - $remainder);
        }

        return base64_decode(strtr($input, "-_", "+/"));
    }
}

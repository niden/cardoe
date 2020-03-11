<?php

/**
 * This file is part of the Phalcon.
 *
 * (c) Phalcon Team <team@phalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Helper;

use const MB_CASE_UPPER;

/**
 * This class offers quick boolean functions throughout the framework
 */
class BoolVal
{
    /**
     * Checks if the passed value is false
     *
     * @param mixed $input
     *
     * @return bool
     */
    final public static function isFalse($input): bool
    {
        $false = [
            '0'     => 1,
            'f'     => 1,
            'false' => 1,
            'n'     => 1,
            'no'    => 1,
        ];

        return isset($false[(string) Str::lower($input)]);
    }

    /**
     * Checks if the passed value is true
     *
     * @param mixed $input
     *
     * @return bool
     */
    final public static function isTrue($input): bool
    {
        $false = [
            '1'    => 1,
            'true' => 1,
            't'    => 1,
            'y'    => 1,
            'yes'  => 1,
        ];

        return isset($false[Str::lower((string) $input)]);
    }
}

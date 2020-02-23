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

namespace Phalcon\Filter\Sanitize;

use function function_exists;
use function mb_strlen;
use function strlen;
use function strtolower;
use function strtoupper;
use function utf8_decode;

use const MB_CASE_UPPER;

/**
 * Phalcon\Filter\Sanitize\AbsInt
 *
 * Sanitizes a value to absolute integer
 */
abstract class AbstractFilter
{
    /**
     * @param string $input
     *
     * @return int
     */
    protected function len(string $input): int
    {
        if (true === function_exists("mb_strlen")) {
            return mb_strlen($input, "UTF-8");
        }

        return strlen(utf8_decode($input));
    }

    /**
     * @param string $input
     *
     * @return string
     */
    protected function lower(string $input): string
    {
        if (true === function_exists("mb_convert_case")) {
            return mb_convert_case($input, MB_CASE_LOWER, "UTF-8");
        }

        return strtolower(utf8_decode($input));
    }

    /**
     * @param string   $input
     * @param int      $start
     * @param int|null $length
     *
     * @return string
     */
    protected function substr(string $input, int $start, int $length = null)
    {
        if (true === function_exists("mb_substr")) {
            return mb_substr($input, $start, $length, 'UTF-8');
        }

        $split = preg_split(
            "//u",
            $input,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        return implode('', array_slice($split, $start, $length));
    }

    /**
     * @param string $input
     *
     * @return string
     */
    protected function upper(string $input): string
    {
        if (true === function_exists("mb_convert_case")) {
            return mb_convert_case($input, MB_CASE_UPPER, "UTF-8");
        }

        return strtoupper(utf8_decode($input));
    }
}

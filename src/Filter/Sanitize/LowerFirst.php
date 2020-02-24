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

use Phalcon\Helper\Str;

/**
 * Phalcon\Filter\Sanitize\LowerFirst
 *
 * Sanitizes a value to lcfirst
 */
class LowerFirst
{
    /**
     * @param string $input The text to sanitize
     *
     * @return string
     */
    public function __invoke(string $input)
    {
        $length = Str::len($input, "UTF-8");
        if (0 === $length) {
            return "";
        }

        if ($length > 1) {
            $first  = mb_substr($input, 0, 1, 'UTF-8');
            $suffix = mb_substr($input, 1, $length - 1, 'UTF-8');

            return Str::lower($first) . $suffix;
        }

        return Str::lower($input);
    }
}

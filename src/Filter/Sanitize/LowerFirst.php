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

/**
 * Phalcon\Filter\Sanitize\LowerFirst
 *
 * Sanitizes a value to lcfirst
 */
class LowerFirst extends AbstractFilter
{
    /**
     * @param string $input The text to sanitize
     *
     * @return string
     */
    public function __invoke(string $input)
    {
        $length = $this->len($input);
        if (0 === $length) {
            return "";
        }

        if ($length > 1) {
            $first  = $this->substr($input, 0, 1);
            $suffix = $this->substr($input, 1, $length - 1);

            return $this->lower($first) . $suffix;
        }

        return $this->lower($input);
    }
}

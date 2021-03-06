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
 * Phalcon\Filter\Sanitize\Replace
 *
 * Sanitizes a value replacing parts of a string
 */
class Replace
{
    /**
     * @var mixed input The text to sanitize
     */
    /**
     * @param mixed           $input
     * @param string|string[] $from
     * @param string|string[] $to
     *
     * @return string|string[]
     */
    public function __invoke($input, $from, $to)
    {
        return str_replace($from, $to, $input);
    }
}

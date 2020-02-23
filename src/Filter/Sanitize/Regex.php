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
 * Phalcon\Filter\Sanitize\Regex
 *
 * Sanitizes a value performing preg_replace
 */
class Regex
{
    /**
     * @var mixed input The text to sanitize
     */
    /**
     * @param mixed           $input
     * @param string|string[] $pattern
     * @param string|string[] $replace
     *
     * @return string|string[]|null
     */
    public function __invoke($input, $pattern, $replace)
    {
        return preg_replace($pattern, $replace, $input);
    }
}

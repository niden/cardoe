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
 * Phalcon\Filter\Sanitize\Alnum
 *
 * Sanitizes a value to an alphanumeric value
 */
class Alnum
{
    /**
     * @return string|string[]|null
     * @var mixed input The text to sanitize
     *
     */
    public function __invoke($input)
    {
        return preg_replace("/[^A-Za-z0-9]/", "", $input);
    }
}

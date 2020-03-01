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
 * Phalcon\Filter\Sanitize\AbsInt
 *
 * Sanitizes a value to absolute integer
 */
class AbsInt
{
    /**
     * @return float|int
     * @var mixed input The text to sanitize
     *
     */
    public function __invoke($input)
    {
        return abs(
            intval(
                filter_var($input, FILTER_SANITIZE_NUMBER_INT)
            )
        );
    }
}

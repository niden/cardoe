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
 * Phalcon\Filter\Sanitize\BoolVal
 *
 * Sanitizes a value to boolean
 */
class BoolVal
{
    /**
     * @return bool
     * @var mixed input The text to sanitize
     *
     *
     */
    public function __invoke($input)
    {
        $trueArray  = ["true", "on", "yes", "y", "1"];
        $falseArray = ["false", "off", "no", "n", "0"];

        if (true === in_array($input, $trueArray)) {
            return true;
        }

        if (true === in_array($input, $falseArray)) {
            return false;
        }

        return (bool) $input;
    }
}

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
 * Phalcon\Filter\Sanitize\Upper
 *
 * Sanitizes a value to uppercase
 */
class Upper extends AbstractFilter
{
    /**
     * @param string $input The text to sanitize
     *
     * @return false|string|string[]|null
     */
    public function __invoke(string $input)
    {
        return $this->upper($input);
    }
}

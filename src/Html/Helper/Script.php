<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Html\Helper;

/**
 * Class Scripts
 */
class Script extends Style
{
    /**
     * @return string
     */
    protected function getTag(): string
    {
        return 'script';
    }

    /**
     * Returns the necessary attributes
     *
     * @param string $attribute
     * @param array  $attributes
     *
     * @return array
     */
    protected function getAttributes(string $attribute, array $attributes): array
    {
        $required = [
            'src'  => $attribute,
            'type' => 'text/javascript',
        ];

        unset($attributes["src"]);

        return array_merge($required, $attributes);
    }
}

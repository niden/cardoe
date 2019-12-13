<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Helper;

/**
 * Cardoe\Helper\Obj
 *
 * This class offers object related functions for the framework
 */
class Obj
{
    /**
     * Returns a new instance having set passed element with the parameter
     *
     * @param object $source
     * @param mixed  $element
     * @param string $property
     *
     * @return mixed
     */
    final public static function cloneInstance(object $source, $element, string $property)
    {
        $newInstance              = clone $source;
        $newInstance->{$property} = $element;

        return $newInstance;
    }
}

<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\Message\Traits;

use Phalcon\Http\Message\Exception\InvalidArgumentException;

use function is_string;

/**
 * Trait Common
 *
 * Common methods
 *
 * @package Phalcon\Http\Message
 */
trait CommonTrait
{
    /**
     * Returns a new instance having set the parameter
     *
     * @param mixed  $element
     * @param string $property
     *
     * @return mixed
     */
    protected function cloneInstance($element, string $property)
    {
        $newInstance              = clone $this;
        $newInstance->{$property} = $element;

        return $newInstance;
    }

    /**
     * Checks the element passed if it is a string
     *
     * @param mixed $element
     */
    private function checkStringParameter($element): void
    {
        if (!is_string($element)) {
            throw new InvalidArgumentException(
                'Method requires a string argument'
            );
        }
    }

    /**
     * Checks the element passed; assigns it to the property and returns a
     * clone of the object back
     *
     * @param mixed  $element
     * @param string $property
     *
     * @return mixed
     */
    private function processWith($element, string $property)
    {
        $this->checkStringParameter($element);

        return $this->cloneInstance($element, $property);
    }
}

<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by Zend Diactoros
 * @link    https://github.com/zendframework/zend-diactoros
 * @license https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Phalcon\Http\Message\Exception\InvalidArgumentException;

use function is_string;

/**
 * Common methods
 */
abstract class AbstractCommon
{
    /**
     * Returns a new instance having set the parameter
     *
     * @param mixed  $element
     * @param string $property
     *
     * @return mixed
     */
    final protected function cloneInstance($element, string $property): object
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
    final protected function checkStringParameter($element): void
    {
        if (!is_string($element)) {
            throw new InvalidArgumentException(
                "Method requires a string argument"
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
    final protected function processWith($element, string $property): object
    {
        $this->checkStringParameter($element);

        return $this->cloneInstance($element, $property);
    }
}

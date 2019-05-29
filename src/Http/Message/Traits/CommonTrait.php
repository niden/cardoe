<?php

declare(strict_types=1);

namespace Cardoe\Http\Message\Traits;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use function is_string;

/**
 * Trait Common
 *
 * Common methods
 *
 * @package Cardoe\Http\Message
 */
trait CommonTrait
{
    /**
     * If the value passed is empty it returns it prefixed and suffixed with
     * the passed parameters
     *
     * @param string $value
     * @param string $prefix
     * @param string $suffix
     *
     * @return string
     */
    private function checkValue(string $value, string $prefix = '', string $suffix = ''): string
    {
        if ('' !== $value) {
            $value = $prefix . $value . $suffix;
        }

        return $value;
    }

    /**
     * Checks the element passed if it is a string
     *
     * @param mixed $element
     */
    private function checkStringParameter($element): void
    {
        if (true !== is_string($element)) {
            throw new InvalidArgumentException(
                'Method requires a string argument'
            );
        }
    }

    /**
     * Returns a new instance having set the parameter
     *
     * @param mixed  $element
     * @param string $property
     *
     * @return mixed
     */
    private function cloneInstance($element, string $property)
    {
        $newInstance              = clone $this;
        $newInstance->{$property} = $element;

        return $newInstance;
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

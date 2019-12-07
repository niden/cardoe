<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Collection;

/**
 * Cardoe\Collection
 *
 * Cardoe\Collection is a supercharged object oriented array. It implements
 * ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Serializable
 *
 * It can be used in any part of the application that needs collection of data
 * Such implementations are for instance accessing globals `$_GET`, `$_POST`
 * etc.
 */
class ReadCollection extends Collection
{
    /**
     * Delete the element from the collection
     *
     * @param string $element
     * @param bool   $insensitive
     *
     * @throws Exception
     */
    public function remove(string $element, bool $insensitive = true): void
    {
        throw new Exception('The object is read only');
    }

    /**
     * Set an element in the collection
     *
     * @param string $element
     * @param mixed  $value
     *
     * @throws Exception
     */
    public function set(string $element, $value): void
    {
        throw new Exception('The object is read only');
    }
}

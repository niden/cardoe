<?php

declare(strict_types=1);

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Logger\Adapter;

use Cardoe\Logger\Item;

/**
 * Class Noop
 *
 * @package Cardoe\Logger\Adapter
 */
class Noop extends AbstractAdapter
{
    /**
     * Closes the stream
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * Processes the message i.e. writes it to the file
     *
     * @param Item $item
     */
    public function process(Item $item): void
    {
        // noop
    }
}

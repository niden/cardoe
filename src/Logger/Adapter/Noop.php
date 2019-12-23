<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Logger\Adapter;

use Phalcon\Logger\Item;

/**
 * Class Noop
 *
 * @package Phalcon\Logger\Adapter
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

<?php

declare(strict_types=1);

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Logger\Formatter;

use Cardoe\Logger\Item;

/**
 * Cardoe\Logger\FormatterInterface
 *
 * This interface must be implemented by formatters in Cardoe\Logger
 */
interface FormatterInterface
{
    /**
     * Applies a format to an item
     *
     * @param Item $item
     *
     * @return string|array
     */
    public function format(Item $item);
}

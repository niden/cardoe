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
use function is_array;

/**
 * Cardoe\Logger\Formatter\Syslog
 *
 * Prepares a message to be used in a Syslog backend
 */
class Syslog extends AbstractFormatter
{
    /**
     * Applies a format to a message before sent it to the internal log
     *
     * @param Item $item
     *
     * @return array
     */
    public function format(Item $item): array
    {
        $message = $item->getMessage();
        $type    = $item->getType();
        $context = $item->getContext();

        if (true === is_array($context)) {
            $message = $this->interpolate($message, $context);
        }

        return [$type, $message];
    }
}

<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Message\Stream;

use Cardoe\Http\Message\Stream;

/**
 * Describes a data stream from "php://memory"
 *
 * Typically, an instance will wrap a PHP stream; this interface provides
 * a wrapper around the most common operations, including serialization of
 * the entire stream to a string.
 */
class Memory extends Stream
{
    /**
     * Memory constructor.
     *
     * @param string $mode
     */
    public function __construct($mode = 'rb')
    {
        parent::__construct('php://memory', $mode);
    }
}

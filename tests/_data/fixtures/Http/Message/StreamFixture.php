<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Fixtures\Http\Message;

use Cardoe\Http\Message\Stream;

class StreamFixture extends Stream
{
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function isSeekable(): bool
    {
        return false;
    }

    public function isWritable(): bool
    {
        return false;
    }
}

<?php

declare(strict_types=1);

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message\Traits;

use RuntimeException;

trait StreamTrait
{
    /**
     * @return bool
     */
    abstract public function isReadable(): bool;

    /**
     * @return bool
     */
    abstract public function isSeekable(): bool;

    /**
     * @return bool
     */
    abstract public function isWritable(): bool;

    /**
     * Checks if a handle is available and throws an exception otherwise
     */
    private function checkHandle(): void
    {
        if (null === $this->handle) {
            throw new RuntimeException(
                'A valid resource is required.'
            );
        }
    }

    /**
     * Checks if a handle is readable and throws an exception otherwise
     */
    private function checkReadable(): void
    {
        if (true !== $this->isReadable()) {
            throw new RuntimeException(
                'The resource is not readable.'
            );
        }
    }

    /**
     * Checks if a handle is seekable and throws an exception otherwise
     */
    private function checkSeekable(): void
    {
        if (true !== $this->isSeekable()) {
            throw new RuntimeException(
                'The resource is not seekable.'
            );
        }
    }

    /**
     * Checks if a handle is writeable and throws an exception otherwise
     */
    private function checkWritable(): void
    {
        if (true !== $this->isWritable()) {
            throw new RuntimeException(
                'The resource is not writable.'
            );
        }
    }
}

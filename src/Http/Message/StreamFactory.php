<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Phalcon\Http\Message\Exception\InvalidArgumentException;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

use function fopen;
use function fwrite;
use function get_resource_type;
use function is_resource;
use function rewind;

final class StreamFactory implements StreamFactoryInterface
{
    /**
     * Create a new stream from a string.
     *
     * The stream SHOULD be created with a temporary resource.
     *
     * @param string $content String content with which to populate the stream.
     *
     * @return StreamInterface
     */
    public function createStream(string $content = ''): StreamInterface
    {
        $handle = fopen('php://temp', 'r+b');
        if (false === $handle) {
            throw new InvalidArgumentException(
                'Cannot write to file.'
            );
        }

        fwrite($handle, $content);
        rewind($handle);

        return $this->createStreamFromResource($handle);
    }

    /**
     * Create a stream from an existing file.
     *
     * The file MUST be opened using the given mode, which may be any mode
     * supported by the `fopen` function.
     *
     * The `$filename` MAY be any string supported by `fopen()`.
     *
     * @param string $filename The filename or stream URI to use as basis of
     *                         stream.
     * @param string $mode     The mode with which to open the underlying
     *                         filename/stream.
     *
     * @return StreamInterface
     */
    public function createStreamFromFile(string $filename, string $mode = 'r+b'): StreamInterface
    {
        return new Stream($filename, $mode);
    }

    /**
     * Create a new stream from an existing resource.
     *
     * The stream MUST be readable and may be writable.
     */
    public function createStreamFromResource($phpResource): StreamInterface
    {
        if (
            !is_resource($phpResource) ||
            'stream' !== get_resource_type($phpResource)
        ) {
            throw new InvalidArgumentException(
                'Invalid stream provided'
            );
        }

        return new Stream($phpResource);
    }
}

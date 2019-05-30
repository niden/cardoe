<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use function fopen;
use function fwrite;
use function get_resource_type;
use function is_resource;
use function rewind;

class StreamFactory implements StreamFactoryInterface
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
        $tempResource = fopen('php://temp', 'r+b');

        fwrite($tempResource, $content);
        rewind($tempResource);

        return $this->createStreamFromResource($tempResource);
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
        if (true !== is_resource($phpResource) ||
            'stream' !== get_resource_type($phpResource)) {
            throw new InvalidArgumentException(
                'Invalid stream provided'
            );
        }

        return new Stream($phpResource);
    }
}

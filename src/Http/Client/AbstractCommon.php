<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client;

use Cardoe\Http\Client\Exception\NetworkException;
use Cardoe\Http\Message\ServerRequest;
use Exception;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use function explode;
use function fopen;
use function implode;
use function is_resource;
use function rewind;
use function sprintf;
use function str_replace;
use function stream_copy_to_stream;
use function stream_get_meta_data;
use function strpos;
use function trim;
use function ucwords;

/**
 * Class AbstractTransport
 *
 * @propety StreamFactoryInterface   $streamFactory
 * @propety ResponseFactoryInterface $responseFactory
 * @propety array                    $options
 */
abstract class AbstractCommon
{
    /**
     * Filters headers removing the ones starting with `HTTP/`
     *
     * @param array $headers
     *
     * @return array
     */
    protected function filterHeaders(array $headers): array
    {
        $result = [];
        foreach ($headers as $header) {
            if (strpos($header, 'HTTP/') === 0) {
                $result = [];
            }

            $result[] = $header;
        }

        return $result;
    }

    /**
     * @param RequestInterface $request
     *
     * @return false|resource
     */
    protected function getTemporaryStream(RequestInterface $request)
    {
        try {
            $resource = fopen('php://temp', 'rb+');
        } catch (Exception $ex) {
            throw new NetworkException(
                'Cannot open temporary stream',
                $request
            );
        }

        if (false === $resource) {
            throw new NetworkException(
                'Cannot open temporary stream',
                $request
            );
        }

        return $resource;
    }

    /**
     * @param StreamInterface        $stream
     * @param StreamFactoryInterface $factory
     * @param RequestInterface       $request
     *
     * @return StreamInterface
     */
    protected function inflate(
        StreamInterface $stream,
        StreamFactoryInterface $factory,
        RequestInterface $request
    ): StreamInterface {
        $stream->rewind();
        $stream->read(10);

        $resource = $this->getTemporaryStream($request);

        while (!$stream->eof()) {
            fwrite($resource, $stream->read(1048576));
        }

        fseek($resource, 0);

        stream_filter_append($resource, "zlib.inflate", STREAM_FILTER_READ);

        return $this->resourceToStream($resource, $factory, $request);
    }

    /**
     * Normalizes a header removing `-` characters
     *
     * @param string $header
     *
     * @return string
     */
    protected function normalizeHeader(string $header): string
    {
        $header   = str_replace('-', ' ', $header);
        $filtered = ucwords($header);

        return str_replace(' ', '-', $filtered);
    }

    /**
     * Copies a resource to a stream
     *
     * @param mixed                  $resource
     * @param StreamFactoryInterface $factory
     * @param RequestInterface       $request
     *
     * @return StreamInterface
     */
    protected function resourceToStream(
        $resource,
        StreamFactoryInterface $factory,
        RequestInterface $request
    ): StreamInterface {
        if (true !== is_resource($resource)) {
            throw new InvalidArgumentException(
                "The resource parameter needs to be of type 'resource'"
            );
        }

        if (true === stream_get_meta_data($resource)['seekable']) {
            rewind($resource);
        }

        $tempResource = $this->getTemporaryStream($request);

        stream_copy_to_stream($resource, $tempResource);

        $stream = $factory->createStreamFromResource($tempResource);
        $stream->rewind();

        return $stream;
    }

    /**
     * Serializes headers from PSR-7
     *
     * @param array $headers
     *
     * @return string
     */
    protected function serializeHeaders(array $headers): string
    {
        $result = [];
        foreach ($headers as $header => $values) {
            $normalized = $this->normalizeHeader($header);
            foreach ($values as $value) {
                $result[] = sprintf('%s: %s', $normalized, $value);
            }
        }

        return implode("\r\n", $result);
    }

    /**
     * Unserializes headers as required for PSR-7
     *
     * @param array $headers
     *
     * @return array
     */
    protected function unserializeHeaders(array $headers): array
    {
        $result = [];

        foreach ($headers as $header) {
            $parts                     = explode(':', $header, 2);
            $result[trim($parts[0])][] = trim($parts[1] ?? null);
        }

        return $result;
    }
}

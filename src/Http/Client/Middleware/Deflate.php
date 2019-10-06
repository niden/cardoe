<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Middleware;

use Cardoe\Http\Client\Exception\NetworkException;
use Cardoe\Http\Client\Request\HandlerInterface;
use Exception;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use function fopen;
use function fseek;
use function fwrite;
use function is_resource;
use function rewind;
use function stream_copy_to_stream;
use function stream_filter_append;
use function stream_get_meta_data;
use const STREAM_FILTER_READ;

/**
 * Class Deflate
 *
 * @property StreamFactoryInterface $streamFactory
 */
class Deflate implements MiddlewareInterface
{
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @param StreamFactoryInterface $streamFactory
     */
    public function __construct(StreamFactoryInterface $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

    /**
     * @inheritdoc
     */
    public function process(
        RequestInterface $request,
        HandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);

        if (true === $response->hasHeader('Content-Encoding')) {
            $encoding = $response->getHeader('Content-Encoding');
            if ($encoding[0] === 'gzip' || $encoding[0] === 'deflate') {
                $stream = $this->inflate(
                    $response->getBody(),
                    $this->streamFactory,
                    $request
                );

                $response = $response
                    ->withBody($stream)
                    ->withHeader('Content-Encoding-Original', $encoding)
                    ->withoutHeader('Content-Encoding');

                if (true === $response->hasHeader('Content-Length')) {
                    $response = $response
                        ->withHeader(
                            'Content-Length-Original',
                            $response->getHeader('Content-Length')[0]
                        )
                        ->withHeader(
                            'Content-Length',
                            (string) $response->getBody()->getSize()
                        );
                }
            }
        }

        return $response;
    }

    private function inflate(
        StreamInterface $stream,
        StreamFactoryInterface $factory,
        RequestInterface $request
    ): StreamInterface {
        $stream->rewind();
        $stream->read(10);

        try {
            $resource = fopen('php://temp', 'rb+');
        } catch (Exception $ex) {
            throw new NetworkException(
                'Cannot open temporary stream',
                $request
            );
        }

        while (!$stream->eof()) {
            fwrite($resource, $stream->read(1048576));
        }

        fseek($resource, 0);

        stream_filter_append($resource, "zlib.inflate", STREAM_FILTER_READ);

        return $this->resourceToStream($resource, $factory, $request);
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
    private function resourceToStream(
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

        try {
            $tempResource = fopen('php://temp', 'rb+');
        } catch (Exception $ex) {
            throw new NetworkException(
                'Cannot open temporary stream',
                $request
            );
        }

        stream_copy_to_stream($resource, $tempResource);

        $stream = $factory->createStreamFromResource($tempResource);
        $stream->rewind();

        return $stream;
    }
}

<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Middleware;

use Cardoe\Http\Client\AbstractCommon;
use Cardoe\Http\Client\Request\HandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class Deflate
 *
 * @property StreamFactoryInterface $streamFactory
 */
class Deflate extends AbstractCommon implements MiddlewareInterface
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
                    ->withoutHeader('Content-Encoding')
                ;

                if (true === $response->hasHeader('Content-Length')) {
                    $response = $response
                        ->withHeader(
                            'Content-Length-Original',
                            $response->getHeader('Content-Length')[0]
                        )
                        ->withHeader(
                            'Content-Length',
                            (string) $response->getBody()->getSize()
                        )
                    ;
                }
            }
        }

        return $response;
    }
}

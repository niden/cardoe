<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Transport;

use Cardoe\Helper\Arr;
use Cardoe\Http\Client\AbstractCommon;
use Cardoe\Http\Client\Middleware\MiddlewareInterface;
use Cardoe\Http\Client\Request\HandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class AbstractTransport
 *
 * @propety StreamFactoryInterface   $streamFactory
 * @propety ResponseFactoryInterface $responseFactory
 * @propety array                    $options
 */
abstract class AbstractTransport extends AbstractCommon implements TransportInterface, MiddlewareInterface
{
    /**
     * @var StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param StreamFactoryInterface   $streamFactory
     * @param ResponseFactoryInterface $responseFactory
     * @param array                    $options
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        array $options = []
    ) {
        $options["followLocation"] = Arr::get(
            $options,
            "followLocation",
            true,
            "bool"
        );
        $options["timeout"]        = Arr::get(
            $options,
            "timeout",
            10,
            "int"
        );

        $this->streamFactory   = $streamFactory;
        $this->responseFactory = $responseFactory;
        $this->options         = $options;
    }

    /**
     * @param RequestInterface $request
     * @param HandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(RequestInterface $request, HandlerInterface $handler): ResponseInterface
    {
        return $this->sendRequest($request);
    }
}

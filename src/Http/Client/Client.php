<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client;

use Cardoe\Http\Client\Middleware\Fallback;
use Cardoe\Http\Client\Middleware\MiddlewareInterface;
use Cardoe\Http\Client\Request\Handler;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 *
 * @package Cardoe\Http\Client
 *
 * @property array|MiddlewareInterface[] $collection
 * @property ResponseFactoryInterface    $factory
 */
class Client implements ClientInterface
{
    /**
     * @var array|MiddlewareInterface[]
     */
    private $collection = [];

    /**
     * @var ResponseFactoryInterface
     */
    private $factory;

    /**
     * Client constructor.
     *
     * @param array                    $collection
     * @param ResponseFactoryInterface $factory
     */
    public function __construct(
        array $collection,
        ResponseFactoryInterface $factory
    ) {
        $this->factory = $factory;
        foreach ($collection as $middleware) {
            if ($middleware instanceof MiddlewareInterface) {
                $this->collection[] = $middleware;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $handler = new Handler(
            $this->collection,
            new Fallback($this->factory)
        );

        return $handler->handle($request);
    }
}

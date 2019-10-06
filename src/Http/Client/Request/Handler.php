<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Request;

use Cardoe\Http\Client\Middleware\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Handler
 *
 * @property MiddlewareInterface[] $collection
 * @property MiddlewareInterface   $fallback
 */
class Handler implements HandlerInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private $collection;

    /**
     * @var MiddlewareInterface
     */
    private $fallback;

    /**
     * Handler constructor.
     *
     * @param MiddlewareInterface[] $collection
     * @param MiddlewareInterface   $fallback
     */
    public function __construct(array $collection, MiddlewareInterface $fallback)
    {
        $this->fallback = $fallback;
        foreach ($collection as $middleware) {
            if ($middleware instanceof MiddlewareInterface) {
                $this->collection[] = $middleware;
            }
        }
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        if (0 === count($this->collection)) {
            return $this->fallback->process($request, $this);
        }

        $middleware = array_shift($this->collection);

        return $middleware->process($request, $this);
    }
}

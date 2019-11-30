<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client\Middleware;

use Cardoe\Http\Client\Request\HandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface MiddlewareInterface
 */
interface MiddlewareInterface
{
    /**
     * @param RequestInterface $request
     * @param HandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(
        RequestInterface $request,
        HandlerInterface $handler
    ): ResponseInterface;
}

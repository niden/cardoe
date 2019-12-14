<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

final class RequestFactory implements RequestFactoryInterface
{
    /**
     * Create a new request.
     */
    /**
     * @param string              $method
     * @param UriInterface|string $uri
     *
     * @return RequestInterface
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        return new Request($method, $uri);
    }
}

<?php

declare(strict_types=1);

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message;

use Cardoe\Http\Message\Stream\Input;
use Cardoe\Http\Message\Traits\CommonTrait;
use Cardoe\Http\Message\Traits\MessageTrait;
use Cardoe\Http\Message\Traits\RequestTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Representation of an outgoing, client-side request.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - HTTP method
 * - URI
 * - Headers
 * - Message body
 *
 * During construction, implementations MUST attempt to set the Host header from
 * a provided URI if no Host header is provided.
 *
 * Requests are considered immutable; all methods that might change state MUST
 * be implemented such that they retain the internal state of the current
 * message and return an instance that contains the changed state.
 */
final class Request implements RequestInterface
{
    use CommonTrait;
    use MessageTrait;
    use RequestTrait;

    /**
     * Request constructor.
     *
     * @param string                          $method
     * @param UriInterface|string|null        $uri
     * @param StreamInterface|resource|string $body
     * @param array                           $headers
     */
    public function __construct(
        string $method = 'GET',
        $uri = null,
        $body = 'php://memory',
        $headers = []
    ) {
        if ('php://input' === $body) {
            $body = new Input();
        }

        $this->uri     = $this->processUri($uri);
        $this->headers = $this->processHeaders($headers);
        $this->method  = $this->processMethod($method);
        $this->body    = $this->processBody($body, 'w+b');
    }
}

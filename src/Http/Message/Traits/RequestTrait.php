<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Message\Traits;

use Cardoe\Collection\Collection;
use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Uri;
use Psr\Http\Message\UriInterface;

use function is_string;
use function preg_match;

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
trait RequestTrait
{
    /**
     * @var Collection
     */
    private $headers;

    /**
     * Retrieves the HTTP method of the request.
     *
     * @var string
     */
    private $method = 'GET';

    /**
     * The request-target, if it has been provided or calculated.
     *
     * @var null|string
     */
    private $requestTarget;

    /**
     * Retrieves the URI instance.
     *
     * This method MUST return a UriInterface instance.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-4.3
     *
     * @var UriInterface
     */
    private $uri;

    /**
     * Return the current method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Retrieves the message's request target.
     *
     * Retrieves the message's request-target either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI, unless a
     * value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * @return string
     */
    public function getRequestTarget(): string
    {
        $requestTarget = $this->requestTarget;

        if (null === $requestTarget) {
            $requestTarget = $this->uri->getPath();

            if (true !== empty($this->uri->getQuery())) {
                $requestTarget .= '?' . $this->uri->getQuery();
            }

            if (true === empty($requestTarget)) {
                $requestTarget = '/';
            }
        }

        return $requestTarget;
    }

    /**
     * Returns the current Uri
     *
     * @return UriInterface
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * Return an instance with the provided HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request method.
     *
     * @param string $method
     *
     * @return self
     * @throws InvalidArgumentException for invalid HTTP methods.
     *
     */
    public function withMethod($method): self
    {
        $this->processMethod($method);

        return $this->cloneInstance($method, 'method');
    }

    /**
     * Return an instance with the specific request-target.
     *
     * If the request needs a non-origin-form request-target — e.g., for
     * specifying an absolute-form, authority-form, or asterisk-form —
     * this method may be used to create an instance with the specified
     * request-target, verbatim.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @see http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
     *     request-target forms allowed in request messages)
     *
     * @param mixed $requestTarget
     *
     * @return self
     */
    public function withRequestTarget($requestTarget): self
    {
        if (preg_match('/\s/', $requestTarget)) {
            throw new InvalidArgumentException(
                'Invalid request target: cannot contain whitespace'
            );
        }

        return $this->cloneInstance($requestTarget, 'requestTarget');
    }

    /**
     * Returns an instance with the provided URI.
     *
     * This method MUST update the Host header of the returned request by
     * default if the URI contains a host component. If the URI does not
     * contain a host component, any pre-existing Host header MUST be carried
     * over to the returned request.
     *
     * You can opt-in to preserving the original state of the Host header by
     * setting `$preserveHost` to `true`. When `$preserveHost` is set to
     * `true`, this method interacts with the Host header in the following
     * ways:
     *
     * - If the Host header is missing or empty, and the new URI contains
     *   a host component, this method MUST update the Host header in the
     *   returned request.
     * - If the Host header is missing or empty, and the new URI does not
     * contain a host component, this method MUST NOT update the Host header in
     * the returned request.
     * - If a Host header is present and non-empty, this method MUST NOT update
     *   the Host header in the returned request.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new UriInterface instance.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-4.3
     *
     * @param UriInterface $uri
     * @param bool         $preserveHost
     *
     * @return self
     */
    public function withUri(UriInterface $uri, $preserveHost = false): self
    {
        $preserveHost     = (bool) $preserveHost;
        $headers          = clone $this->headers;
        $newInstance      = clone $this;
        $newInstance->uri = $uri;

        if (true !== $preserveHost) {
            $headers = $this->checkHeaderHost($headers);

            $newInstance->headers = $headers;
        }

        return $newInstance;
    }

    abstract protected function checkHeaderHost(Collection $collection): Collection;

    abstract protected function cloneInstance($element, string $property);

    /**
     * Check the method
     *
     * @param string $method
     *
     * @return string
     */
    private function processMethod($method = ''): string
    {
        $methods = [
            'GET'     => 1,
            'CONNECT' => 1,
            'DELETE'  => 1,
            'HEAD'    => 1,
            'OPTIONS' => 1,
            'PATCH'   => 1,
            'POST'    => 1,
            'PUT'     => 1,
            'TRACE'   => 1,
        ];

        if (
            !(!empty($method) &&
            is_string($method) &&
            isset($methods[$method]))
        ) {
            throw new InvalidArgumentException(
                'Invalid or unsupported method ' . $method
            );
        }

        return $method;
    }

    /**
     * Sets a valid Uri
     *
     * @param mixed $uri
     *
     * @return UriInterface
     */
    private function processUri($uri): UriInterface
    {
        if ($uri instanceof UriInterface) {
            return $uri;
        }

        if (is_string($uri)) {
            return new Uri($uri);
        }

        if (null === $uri) {
            return new Uri();
        }

        throw new InvalidArgumentException(
            'Invalid uri passed as a parameter'
        );
    }
}

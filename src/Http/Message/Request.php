<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message;

use function array_unshift;
use Cardoe\Collection\Collection;
use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Stream\Input;
use Cardoe\Http\Message\Traits\CommonTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use function array_merge;
use function implode;
use function is_array;
use function is_numeric;
use function is_resource;
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
class Request implements RequestInterface
{
    use CommonTrait;

    /**
     * Gets the body of the message.
     *
     * @var StreamInterface
     */
    private $body;

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
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., '1.1',
     * '1.0').
     *
     * @return string HTTP protocol version.
     *
     * @var string
     */
    private $protocolVersion = '1.1';

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
     * Request constructor.
     *
     * @param string $method
     * @param null   $uri
     * @param string $body
     * @param array  $headers
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

    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * This method returns an array of all the header values of the given
     * case-insensitive header name.
     *
     * If the header does not appear in the message, this method MUST return an
     * empty array.
     *
     * @param string $name
     *
     * @return array
     */
    public function getHeader($name): array
    {
        $name = (string) $name;

        return $this->headers->get($name, []);
    }

    /**
     * Retrieves a comma-separated string of the values for a single header.
     *
     * This method returns all of the header values of the given
     * case-insensitive header name as a string concatenated together using
     * a comma.
     *
     * NOTE: Not all header values may be appropriately represented using
     * comma concatenation. For such headers, use getHeader() instead
     * and supply your own delimiter when concatenating.
     *
     * If the header does not appear in the message, this method MUST return
     * an empty string.
     *
     * @param string $name
     *
     * @return string
     */
    public function getHeaderLine($name): string
    {
        $header = $this->getHeader($name);

        return implode(',', $header);
    }

    /**
     * Retrieves all message header values.
     *
     * The keys represent the header name as it will be sent over the wire, and
     * each value is an array of strings associated with the header.
     *
     *     // Represent the headers as a string
     *     foreach ($message->getHeaders() as $name => $values) {
     *         echo $name . ': ' . implode(', ', $values);
     *     }
     *
     *     // Emit headers iteratively:
     *     foreach ($message->getHeaders() as $name => $values) {
     *         foreach ($values as $value) {
     *             header(sprintf('%s: %s', $name, $value), false);
     *         }
     *     }
     *
     * While header names are not case-sensitive, getHeaders() will preserve the
     * exact case in which headers were originally specified.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers->toArray();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
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

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * Checks if a header exists by the given case-insensitive name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasHeader($name): bool
    {
        return $this->headers->has($name);
    }

    /**
     * Return an instance with the specified header appended with the given
     * value.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new header and/or value.
     *
     * @param string          $name
     * @param string|string[] $value
     *
     * @return Request
     */
    public function withAddedHeader($name, $value): Request
    {
        $this->checkHeaderName($name);

        $headers  = clone $this->headers;
        $existing = $headers->get($name, []);
        $value    = $this->getHeaderValue($value);
        $value    = array_merge($existing, $value);

        $headers->set($name, $value);

        return $this->cloneInstance($headers, 'headers');
    }

    /**
     * Return an instance with the specified message body.
     *
     * The body MUST be a StreamInterface object.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * new body stream.
     *
     * @param StreamInterface $body
     *
     * @return Request
     * @throws InvalidArgumentException When the body is not valid.
     *
     */
    public function withBody(StreamInterface $body): Request
    {
        $newBody = $this->processBody($body, 'w+b');

        return $this->cloneInstance($newBody, 'body');
    }

    /**
     * Return an instance with the provided value replacing the specified
     * header.
     *
     * While header names are case-insensitive, the casing of the header will
     * be preserved by this function, and returned from getHeaders().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new and/or updated header and value.
     *
     * @param string          $name
     * @param string|string[] $value
     *
     * @return Request
     * @throws \InvalidArgumentException for invalid header names or values.
     *
     */
    public function withHeader($name, $value): Request
    {
        $this->checkHeaderName($name);

        $headers = clone $this->headers;
        $value   = $this->getHeaderValue($value);

        $headers->set($name, $value);

        return $this->cloneInstance($headers, 'headers');
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
     * @return Request
     * @throws InvalidArgumentException for invalid HTTP methods.
     *
     */
    public function withMethod($method): Request
    {
        $this->processMethod($method);

        return $this->cloneInstance($method, 'method');
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * '1.1', '1.0').
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new protocol version.
     *
     * @param string $version
     *
     * @return Request
     */
    public function withProtocolVersion($version): Request
    {
        $this->processProtocol($version);

        return $this->cloneInstance($version, 'protocolVersion');
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
     * @return Request
     */
    public function withRequestTarget($requestTarget): Request
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
     * @return Request
     */
    public function withUri(UriInterface $uri, $preserveHost = false): Request
    {
        $preserveHost     = (bool) $preserveHost;
        $headers          = clone $this->headers;
        $newInstance      = clone $this;
        $newInstance->uri = $uri;

        if (!(true === $preserveHost &&
            true === $headers->has('Host') &&
            '' !== $uri->getHost())) {
            $host = $this->getUriHost($uri);

            $headers->set('Host', [$host]);

            $newInstance->headers = $headers;
        }

        return $newInstance;
    }

    /**
     * Return an instance without the specified header.
     *
     * Header resolution MUST be done without case-sensitivity.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the named header.
     *
     * @param string $name
     *
     * @return Request
     */
    public function withoutHeader($name): Request
    {
        $headers = clone $this->headers;
        $headers->remove($name);

        return $this->cloneInstance($headers, 'headers');
    }

    /**
     * Check the name of the header. Throw exception if not valid
     *
     * @see http://tools.ietf.org/html/rfc7230#section-3.2
     *
     * @param $name
     */
    private function checkHeaderName($name): void
    {
        if (true !== is_string($name) ||
            !preg_match("/^[a-zA-Z0-9\'`#$%&*+.^_|~!-]+$/", $name)) {
            throw new InvalidArgumentException(
                'Invalid header name ' . $name
            );
        }
    }

    /**
     * Validates a header value
     *
     * Most HTTP header field values are defined using common syntax
     * components (token, quoted-string, and comment) separated by
     * whitespace or specific delimiting characters.  Delimiters are chosen
     * from the set of US-ASCII visual characters not allowed in a token
     * (DQUOTE and '(),/:;<=>?@[\]{}').
     *
     *     token          = 1*tchar
     *
     *     tchar          = '!' / '#' / '$' / '%' / '&' / ''' / '*'
     *                    / '+' / '-' / '.' / '^' / '_' / '`' / '|' / '~'
     *                    / DIGIT / ALPHA
     *                    ; any VCHAR, except delimiters
     *
     * A string of text is parsed as a single value if it is quoted using
     * double-quote marks.
     *
     *     quoted-string  = DQUOTE *( qdtext / quoted-pair ) DQUOTE
     *     qdtext         = HTAB / SP /%x21 / %x23-5B / %x5D-7E / obs-text
     *     obs-text       = %x80-FF
     *
     * Comments can be included in some HTTP header fields by surrounding
     * the comment text with parentheses.  Comments are only allowed in
     * fields containing 'comment' as part of their field value definition.
     *
     *     comment        = '(' *( ctext / quoted-pair / comment ) ')'
     *     ctext          = HTAB / SP / %x21-27 / %x2A-5B / %x5D-7E / obs-text
     *
     * The backslash octet ('\') can be used as a single-octet quoting
     * mechanism within quoted-string and comment constructs.  Recipients
     * that process the value of a quoted-string MUST handle a quoted-pair
     * as if it were replaced by the octet following the backslash.
     *
     *     quoted-pair    = '\' ( HTAB / SP / VCHAR / obs-text )
     *
     * A sender SHOULD NOT generate a quoted-pair in a quoted-string except
     * where necessary to quote DQUOTE and backslash octets occurring within
     * that string.  A sender SHOULD NOT generate a quoted-pair in a comment
     * except where necessary to quote parentheses ['(' and ')'] and
     * backslash octets occurring within that comment.
     *
     * @see https://tools.ietf.org/html/rfc7230#section-3.2.6
     *
     * @param $value
     */
    private function checkHeaderValue($value): void
    {
        if (true !== is_string($value) && true !== is_numeric($value)) {
            throw new InvalidArgumentException('Invalid header value');
        }

        $value = (string) $value;

        if (preg_match("#(?:(?:(?<!\r)\n)|(?:\r(?!\n))|(?:\r\n(?![ \t])))#", $value) ||
            preg_match("/[^\x09\x0a\x0d\x20-\x7E\x80-\xFE]/", $value)) {
            throw new InvalidArgumentException('Invalid header value');
        }
    }

    /**
     * Returns the header values checked for validity
     *
     * @param $values
     *
     * @return array
     */
    private function getHeaderValue($values): array
    {
        if (true !== is_array($values)) {
            $values = [$values];
        }

        if (true === empty($values)) {
            throw new InvalidArgumentException(
                'Invalid header value: must be a string or ' .
                'array of strings; cannot be an empty array'
            );
        }

        $valueData = [];

        foreach ($values as $value) {
            $this->checkHeaderValue($value);

            $valueData[] = (string) $value;
        }

        return $valueData;
    }

    /**
     * Return the host and if applicable the port
     *
     * @param UriInterface $uri
     *
     * @return string
     */
    private function getUriHost(UriInterface $uri): string
    {
        $host = $uri->getHost();

        if (null !== $uri->getPort()) {
            $host .= ':' . $uri->getPort();
        }

        return $host;
    }

    /**
     * Set a valid stream
     *
     * @param string $body
     * @param string $mode
     *
     * @return StreamInterface
     */
    private function processBody($body = 'php://memory', string $mode = 'r+b'): StreamInterface
    {
        if ($body instanceof StreamInterface) {
            return $body;
        }

        if (true !== is_string($body) && true !== is_resource($body)) {
            throw new InvalidArgumentException(
                'Invalid stream passed as a parameter'
            );
        }

        return new Stream($body, $mode);
    }

    /**
     * Sets the headers
     *
     * @param $headers
     *
     * @return Collection
     */
    private function processHeaders($headers): Collection
    {
        if (true === is_array($headers)) {
            $collection = new Collection();

            foreach ($headers as $name => $value) {
                $this->checkHeaderName($name);

                $name  = (string) $name;
                $value = $this->getHeaderValue($value);

                $collection->set($name, $value);
            }

            /**
             * Ensure Host is the first header.
             * See: http://tools.ietf.org/html/rfc7230#section-5.4
             */
            if (true === $collection->has('host') &&
                true !== empty($this->uri) &&
                '' !== $this->uri->getHost()) {
                $host = $this->getUriHost($this->uri);
                $collection->set('Host', [$host]);

                $data   = $collection->toArray();
                $header = $data['Host'];
                unset($data['Host']);
                $data = ['Host' => $header] + $data;
                $collection->clear();
                $collection->init($data);
            }
        } else {
            if (!($headers instanceof Collection)) {
                throw new InvalidArgumentException(
                    'Headers needs to be either an array or instance of Cardoe\Collection'
                );
            }

            $collection = $headers;
        }

        return $collection;
    }

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

        if (!(true !== empty($method) &&
            true === is_string($method) &&
            true === isset($methods[$method]))) {
            throw new InvalidArgumentException(
                'Invalid or unsupported method ' . $method
            );
        }

        return $method;
    }

    /**
     * Checks the protocol
     *
     * @param string $protocol
     *
     * @return string
     */
    private function processProtocol($protocol = ''): string
    {
        $protocols = [
            '1.0' => 1,
            '1.1' => 1,
            '2.0' => 1,
            '3.0' => 1,
        ];

        if (true === empty($protocol) || true !== is_string($protocol)) {
            throw new InvalidArgumentException('Invalid protocol value');
        }

        if (true !== isset($protocols[$protocol])) {
            throw new InvalidArgumentException(
                'Unsupported protocol ' . $protocol
            );
        }

        return $protocol;
    }

    /**
     * Sets a valid Uri
     *
     * @param UriInterface|string $uri
     *
     * @return UriInterface
     */
    private function processUri($uri): UriInterface
    {
        $uri = (null === $uri) ? '' : $uri;
        if ($uri instanceof UriInterface) {
            $localUri = $uri;
        } elseif (true === is_string($uri)) {
            $localUri = new Uri($uri);
        } else {
            throw new InvalidArgumentException(
                'Invalid uri passed as a parameter'
            );
        }

        return $localUri;
    }
}

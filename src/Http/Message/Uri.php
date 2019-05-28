<?php

declare(strict_types=1);

namespace Cardoe\Http\Message;

use Cardoe\Helper\Arr;
use Cardoe\Helper\Str;
use InvalidArgumentException;
use Psr\Http\Message\UriInterface;
use function array_keys;
use function explode;
use function get_class;
use function implode;
use function is_object;
use function is_string;
use function ltrim;
use function mb_strtolower;
use function parse_url;
use function preg_replace;
use function rawurlencode;
use function strpos;
use function strtolower;
use function substr;

final class Uri implements UriInterface
{
    /**
     * Retrieve the fragment component of the URI.
     *
     * @var string
     */
    private $fragment = '';

    /**
     * @var string
     */
    private $host = '';

    /**
     * Retrieve the path component of the URI.
     *
     * @var string
     */
    private $path = '';

    /**
     * @var null | int
     */
    private $port = null;

    /**
     * Retrieve the query string of the URI.
     *
     * @var string
     */
    private $query = '';

    /**
     * @var string
     */
    private $scheme = 'https';

    /**
     * @var string
     */
    private $pass = '';

    /**
     * @var string
     */
    private $user = '';

    /**
     * Uri constructor.
     *
     * @param string $uri
     */
    public function __construct(string $uri = '')
    {
        if ('' !== $uri) {
            $urlParts = parse_url($uri);

            if (false === $urlParts) {
                $urlParts = [];
            }

            $this->fragment = $this->filterFragment(
                Arr::get($urlParts, 'fragment', '')
            );
            $this->host     = strtolower(
                Arr::get($urlParts, 'host', '')
            );
            $this->pass     = rawurlencode(
                Arr::get($urlParts, 'pass', '')
            );
            $this->path     = $this->filterPath(
                Arr::get($urlParts, 'path', '')
            );
            $this->port     = $this->filterPort(
                Arr::get($urlParts, 'port', null)
            );
            $this->query    = $this->filterQuery(
                Arr::get($urlParts, 'query', '')
            );
            $this->scheme   = $this->filterScheme(
                Arr::get($urlParts, 'scheme', '')
            );
            $this->user     = rawurlencode(
                Arr::get($urlParts, 'user', '')
            );
        }
    }

    /**
     * Return the string representation as a URI reference.
     *
     * Depending on which components of the URI are present, the resulting
     * string is either a full URI or relative reference according to RFC 3986,
     * Section 4.1. The method concatenates the various components of the URI,
     * using the appropriate delimiters
     */
    public function __toString(): string
    {
        $uri = $this->calculateScheme()
            . $this->calculateAuthority()
            . $this->calculatePath()
            . $this->calculateQuery()
            . $this->calculateFragment();

        return $uri;
    }

    /**
     * Retrieve the authority component of the URI.
     */
    public function getAuthority(): string
    {
        /**
         * If no authority information is present, this method MUST return an
         * empty string.
         */
        if ('' === $this->host) {
            return '';
        }

        $authority = $this->host;
        $userInfo  = $this->getUserInfo();

        /**
         * The authority syntax of the URI is:
         *
         * [user-info@]host[:port]
         */
        if ('' !== $userInfo) {
            $authority = $userInfo . '@' . $authority;
        }

        /**
         * If the port component is not set or is the standard port for the
         * current scheme, it SHOULD NOT be included.
         */
        if (null !== $this->port) {
            $authority .= ':' . $this->port;
        }

        return $authority;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    /**
     * Retrieve the host component of the URI.
     *
     * If no host is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.2.2.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-3.2.2
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Retrieve the port component of the URI.
     *
     * If a port is present, and it is non-standard for the current scheme,
     * this method MUST return it as an integer. If the port is the standard
     * port used with the current scheme, this method SHOULD return null.
     *
     * If no port is present, and no scheme is present, this method MUST return
     * a null value.
     *
     * If no port is present, but a scheme is present, this method MAY return
     * the standard port for that scheme, but SHOULD return null.
     *
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Retrieve the scheme component of the URI.
     *
     * If no scheme is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.1.
     *
     * The trailing ':' character is not part of the scheme and MUST NOT be
     * added.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.1
     *
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * Retrieve the user information component of the URI.
     *
     * If no user information is present, this method MUST return an empty
     * string.
     *
     * If a user is present in the URI, this will return that value;
     * additionally, if the password is also present, it will be appended to the
     * user value, with a colon (":") separating the values.
     *
     * The trailing "@" character is not part of the user information and MUST
     * NOT be added.
     *
     * @return string The URI user information, in "username[:password]" format.
     */
    public function getUserInfo(): string
    {
        if (true !== empty($this->pass)) {
            return $this->user . ':' . $this->pass;
        }

        return $this->user;
    }

    /**
     * Return an instance with the specified URI fragment.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified URI fragment.
     *
     * Users can provide both encoded and decoded fragment characters.
     * Implementations ensure the correct encoding as outlined in getFragment().
     *
     * An empty fragment value is equivalent to removing the fragment.
     *
     * @param string $fragment
     *
     * @return Uri
     */
    public function withFragment($fragment): Uri
    {
        $this->checkStringParameter($fragment);

        $fragment = $this->filterFragment($fragment);

        return $this->cloneInstance($fragment, 'fragment');
    }

    /**
     * Return an instance with the specified path.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified path.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * If an HTTP path is intended to be host-relative rather than path-relative
     * then it must begin with a slash ("/"). HTTP paths not starting with a
     * slash are assumed to be relative to some base path known to the
     * application or consumer.
     *
     * Users can provide both encoded and decoded path characters.
     * Implementations ensure the correct encoding as outlined in getPath().
     *
     * @param string $path
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid paths.
     *
     */
    public function withPath($path): Uri
    {
        $this->checkStringParameter($path);

        if (false !== strpos($path, '?')) {
            throw new InvalidArgumentException(
                'Path cannot contain a query string'
            );
        }

        if (false !== strpos($path, '#')) {
            throw new InvalidArgumentException(
                'Path cannot contain a query fragment'
            );
        }

        $path = $this->filterPath($path);

        return $this->cloneInstance($path, 'path');
    }

    /**
     * Return an instance with the specified port.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified port.
     *
     * Implementations MUST raise an exception for ports outside the
     * established TCP and UDP port ranges.
     *
     * A null value provided for the port is equivalent to removing the port
     * information.
     *
     * @param int|null $port
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid ports.
     *
     */
    public function withPort($port): Uri
    {
        if (null !== $port) {
            $port = $this->filterPort($port);

            if (null !== $port && ($port < 1 || $port > 65535)) {
                throw new InvalidArgumentException(
                    'Method expects valid port (1-65535)'
                );
            }
        }

        return $this->cloneInstance($port, 'port');
    }

    /**
     * Return an instance with the specified query string.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified query string.
     *
     * Users can provide both encoded and decoded query characters.
     * Implementations ensure the correct encoding as outlined in getQuery().
     *
     * An empty query string value is equivalent to removing the query string.
     *
     * @param string $query
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid query strings.
     *
     */
    public function withQuery($query): Uri
    {
        $this->checkStringParameter($query);

        if (false !== strpos($query, '#')) {
            throw new InvalidArgumentException(
                'Query cannot contain a query fragment'
            );
        }

        $query = $this->filterQuery($query);

        return $this->cloneInstance($query, 'query');
    }

    /**
     * Return an instance with the specified scheme.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified scheme.
     *
     * Implementations MUST support the schemes "http" and "https" case
     * insensitively, and MAY accommodate other schemes if required.
     *
     * An empty scheme is equivalent to removing the scheme.
     *
     * @param string $scheme
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid schemes.
     * @throws InvalidArgumentException for unsupported schemes.
     *
     */
    public function withScheme($scheme): Uri
    {
        $this->checkStringParameter($scheme);

        $scheme = $this->filterScheme($scheme);

        return $this->processWith($scheme, 'scheme');
    }

    /**
     * Return an instance with the specified user information.
     *
     * @param string      $user
     * @param string|null $password
     *
     * @return Uri
     */
    public function withUserInfo($user, $password = null): self
    {
        $this->checkStringParameter($user);

        if (null !== $password) {
            $this->checkStringParameter($user);
        }

        $user = rawurlencode($user);

        if (null !== $password) {
            $password = rawurlencode($password);
        }

        /**
         * Immutable - need to send a new object back
         */
        $newInstance       = $this->cloneInstance($user, 'user');
        $newInstance->pass = $password;

        return $newInstance;
    }

    /**
     * Return an instance with the specified host.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified host.
     *
     * An empty host value is equivalent to removing the host.
     *
     * @param string $host
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid hostnames.
     *
     */
    public function withHost($host): Uri
    {
        return $this->processWith($host, 'host');
    }

    /**
     * Return the authority if passed
     *
     * @return string
     */
    private function calculateAuthority(): string
    {
        $authority = $this->getAuthority();

        /**
         * If an authority is present, it MUST be prefixed by "//".
         */
        if ('' !== $authority) {
            $authority = '//' . $authority;
        }

        return $authority;
    }

    /**
     * Return the fragment for the __toString()
     *
     * @return string
     */
    private function calculateFragment(): string
    {
        $fragment = $this->fragment;

        if ('' !== $this->fragment) {
            $fragment = '#' . $fragment;
        }

        return $fragment;
    }

    /**
     * Return the path for the __toString()
     *
     * @return string
     */
    private function calculatePath(): string
    {
        $authority = $this->getAuthority();
        $path      = $this->path;

        /**
         * The path can be concatenated without delimiters. But there are two
         * cases where the path has to be adjusted to make the URI reference
         * valid as PHP does not allow to throw an exception in __toString():
         *   - If the path is rootless and an authority is present, the path
         *     MUST be prefixed by "/".
         *   - If the path is starting with more than one "/" and no authority
         *     is present, the starting slashes MUST be reduced to one.
         */
        if ('' !== $path && true !== Str::startsWith($path, '/') && '' !== $authority) {
            $path = '/' . $path;
        }

        return $path;
    }

    /**
     * Return the query for the __toString()
     *
     * @return string
     */
    private function calculateQuery(): string
    {
        $query = $this->query;

        /**
         * If a query is present, it MUST be prefixed by "?".
         */
        if ('' !== $query) {
            $query = '?' . $query;
        }

        return $query;
    }

    /**
     * Return the schema for the __toString()
     *
     * @return string
     */
    private function calculateScheme(): string
    {
        $scheme = $this->scheme;

        /**
         * If a scheme is present, it MUST be suffixed by ":".
         */
        if ('' !== $scheme) {
            $scheme = $scheme . ":";
        }

        return $scheme;
    }

    /**
     * Checks the element passed if it is a string
     *
     * @param mixed $element
     */
    private function checkStringParameter($element): void
    {
        if (true === is_object($element)) {
            $type = get_class($element);
        } else {
            $type = gettype($element);
        }

        if (true !== is_string($element)) {
            throw new InvalidArgumentException(
                'Method requires a string argument instead of ' . $type
            );
        }
    }

    /**
     * Returns a new instance having set the parameter
     *
     * @param mixed  $element
     * @param string $property
     *
     * @return Uri
     */
    private function cloneInstance($element, string $property)
    {
        $newInstance              = clone $this;
        $newInstance->{$property} = $element;

        return $newInstance;
    }

    /**
     * If no fragment is present, this method MUST return an empty string.
     *
     * The leading "#" character is not part of the fragment and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.5.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.5
     *
     * @param string $fragment
     *
     * @return string
     */
    private function filterFragment(string $fragment): string
    {
        return rawurlencode($fragment);
    }

    /**
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * Normally, the empty path "" and absolute path "/" are considered equal as
     * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
     * do this normalization because in contexts with a trimmed base path, e.g.
     * the front controller, this difference becomes significant. It's the task
     * of the user to handle both "" and "/".
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.3.
     *
     * As an example, if the value should include a slash ("/") not intended as
     * delimiter between path segments, that value MUST be passed in encoded
     * form (e.g., "%2F") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.3
     *
     * @param string $path
     *
     * @return string The URI path.
     */
    private function filterPath(string $path): string
    {
        if ('' === $path || true !== Str::startsWith($path, '/')) {
            return $path;
        }

        $parts = explode('/', $path);
        foreach ($parts as $key => $element) {
            $parts[$key] = rawurlencode($element);
        }

        $path = implode('/', $parts);

        return '/' . ltrim($path, '/');
    }

    /**
     * Checks the port. If it is a standard one (80,443) then it returns null
     *
     * @param $port
     *
     * @return int|null
     */
    private function filterPort($port): ?int
    {
        $ports = [
            80  => 1,
            443 => 1,
        ];

        if (null !== $port) {
            $port = (int) $port;
            if (true === isset($ports[$port])) {
                $port = null;
            }
        }

        return $port;
    }

    /**
     * If no query string is present, this method MUST return an empty string.
     *
     * The leading "?" character is not part of the query and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.4.
     *
     * As an example, if a value in a key/value pair of the query string should
     * include an ampersand ("&") not intended as a delimiter between values,
     * that value MUST be passed in encoded form (e.g., "%26") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @param string $query
     *
     * @return string The URI query string.
     */
    private function filterQuery(string $query): string
    {
        if ('' === $query) {
            return '';
        }

        if (true === Str::startsWith($query, '?')) {
            $query = substr($query, 1);
        }

        $parts = explode("&", $query);

        foreach ($parts as $index => $part) {
            [$key, $value] = $this->splitQueryValue($part);
            if (null === $value) {
                $parts[$index] = rawurlencode($key);

                continue;
            }

            $parts[$key] = rawurlencode($key) . '=' . rawurlencode($value);
        }

        return implode('&', $parts);
    }

    /**
     * Filters the passed scheme - only allowed schemes
     *
     * @param string $scheme
     *
     * @return string
     */
    private function filterScheme(string $scheme): string
    {
        $filtered = preg_replace(
            '#:(//)?$#',
            '',
            mb_strtolower($scheme)
        );
        $schemes  = [
            'http'  => 1,
            'https' => 1,
        ];

        if ('' === $filtered) {
            return '';
        }

        if (true !== isset($schemes[$filtered])) {
            throw new InvalidArgumentException(
                "Unsupported scheme [" . $filtered . "]. " .
                "Scheme must be one of [" .
                implode(", ", array_keys($schemes)) . "]"
            );
        }

        return $scheme;
    }

    /**
     * Checks the element passed; assigns it to the property and returns a
     * clone of the object back
     *
     * @param mixed  $element
     * @param string $property
     *
     * @return Uri
     */
    private function processWith($element, string $property): Uri
    {
        $this->checkStringParameter($element);

        return $this->cloneInstance($element, $property);
    }

    /**
     * @param string $element
     *
     * @return array
     */
    private function splitQueryValue(string $element): array
    {
        $data    = explode('=', $element, 2);
        $data[1] = $data[1] ?? null;

        return $data;
    }
}

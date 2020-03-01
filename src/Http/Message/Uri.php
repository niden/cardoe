<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by Zend Diactoros
 *
 * @link    https://github.com/zendframework/zend-diactoros
 * @license https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Phalcon\Helper\Arr;
use Phalcon\Helper\Str;
use Phalcon\Http\Message\Exception\InvalidArgumentException;
use Phalcon\Http\Message\Traits\CommonTrait;
use Phalcon\Http\Message\Traits\UriTrait;
use Psr\Http\Message\UriInterface;

use function parse_url;
use function rawurlencode;
use function strpos;
use function strtolower;

/**
 * PSR-7 Uri
 *
 * @property string   $fragment
 * @property string   $host
 * @property string   $pass
 * @property string   $path
 * @property null|int $port
 * @property string   $query
 * @property string   $scheme
 * @property string   $user
 */
final class Uri implements UriInterface
{
    use CommonTrait;
    use UriTrait;

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
     * @var string
     */
    private $pass = '';

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
                (string) Arr::get($urlParts, 'fragment', '')
            );
            $this->host     = strtolower(
                (string) Arr::get($urlParts, 'host', '')
            );
            $this->pass     = rawurlencode(
                (string) Arr::get($urlParts, 'pass', '')
            );
            $this->path     = $this->filterPath(
                (string) Arr::get($urlParts, 'path', '')
            );
            $this->port     = $this->filterPort(
                Arr::get($urlParts, 'port', null)
            );
            $this->query    = $this->filterQuery(
                (string) Arr::get($urlParts, 'query', '')
            );
            $this->scheme   = $this->filterScheme(
                (string) Arr::get($urlParts, 'scheme', '')
            );
            $this->user     = rawurlencode(
                (string) Arr::get($urlParts, 'user', '')
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
     *
     * @return string
     */
    public function __toString(): string
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

        $uri = $this->checkValue($this->scheme, '', ':')
            . $this->checkValue($authority, '//')
            . $path
            . $this->checkValue($this->query, '?')
            . $this->checkValue($this->fragment, '#');

        return $uri;
    }

    /**
     * Retrieve the authority component of the URI.
     *
     * @return string
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

    /**
     * Returns the fragment of the URL
     *
     * @return string
     */
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

    /**
     * Returns the path of the URL
     *
     * @return string
     */
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

    /**
     * Returns the query of the URL
     *
     * @return string
     */
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
     */
    public function withPath($path): Uri
    {
        $this->checkStringParameter($path);

        if (
            false !== strpos($path, '?') ||
            false !== strpos($path, '#')
        ) {
            throw new InvalidArgumentException(
                'Path cannot contain a query string or fragment'
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
}

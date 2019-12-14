<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Phalcon\Collection;
use Phalcon\Helper\Arr;
use Phalcon\Http\Message\Exception\InvalidArgumentException;
use Phalcon\Http\Message\Traits\ServerRequestFactoryTrait;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriInterface;

use function apache_request_headers;
use function explode;
use function function_exists;
use function implode;
use function is_array;
use function is_string;
use function ltrim;
use function parse_str;
use function preg_match;
use function preg_replace;
use function str_replace;
use function strlen;
use function substr;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
    use ServerRequestFactoryTrait;

    /**
     * Create a new server request.
     *
     * Note that server-params are taken precisely as given - no
     * parsing/processing of the given values is performed, and, in particular,
     * no attempt is made to determine the HTTP method or URI, which must be
     * provided explicitly.
     *
     * @param string              $method       The HTTP method associated with
     *                                          the request.
     * @param UriInterface|string $uri          The URI associated with the
     *                                          request. If the value is a
     *                                          string, the factory MUST create
     *                                          a UriInterface instance based
     *                                          on it.
     * @param array               $serverParams Array of SAPI parameters with
     *                                          which to seed the generated
     *                                          request instance.
     *
     * @return ServerRequestInterface
     */
    public function createServerRequest(
        string $method,
        $uri,
        array $serverParams = []
    ): ServerRequestInterface {
        return new ServerRequest($method, $uri, $serverParams);
    }

    /**
     * Create a request from the supplied superglobal values.
     *
     * If any argument is not supplied, the corresponding superglobal value will
     * be used.
     *
     * The ServerRequest created is then passed to the fromServer() method in
     * order to marshal the request URI and headers.
     *
     * @param array $server  $_SERVER superglobal
     * @param array $get     $_GET superglobal
     * @param array $post    $_POST superglobal
     * @param array $cookies $_COOKIE superglobal
     * @param array $files   $_FILES superglobal
     *
     * @return ServerRequest
     * @see fromServer()
     */
    public function load(
        array $server = [],
        array $get = [],
        array $post = [],
        array $cookies = [],
        array $files = []
    ): ServerRequest {
        $method   = Arr::get($server, 'REQUEST_METHOD', 'GET');
        $protocol = Arr::get($server, 'SERVER_PROTOCOL', '1.1');

        $server  = $this->parseServer($server);
        $headers = $this->parseHeaders($server);
        $files   = $this->parseUploadedFiles($files);

        if (empty($cookies) && $headers->has('cookie')) {
            $cookies = $this->parseCookieHeader($headers->get('cookie'));
        }

        return new ServerRequest(
            $method,
            $this->parseUri($server, $headers),
            $server->toArray(),
            'php://input',
            $headers->toArray(),
            $cookies,
            $get,
            $files->toArray(),
            $post,
            $protocol
        );
    }

    /**
     * Returns the apache_request_headers if it exists
     *
     * @return array|false
     */
    protected function getHeaders()
    {
        if (function_exists('apache_request_headers')) {
            return apache_request_headers();
        }

        return false;
    }

    /**
     * Checks if a header starts with CONTENT_ and adds it to the collection
     *
     * @param string     $key
     * @param mixed      $value
     * @param Collection $headers
     */
    private function checkContentHeader(string $key, $value, Collection $headers): void
    {
        if (mb_strpos($key, 'CONTENT_') === 0) {
            $key  = (string) substr($key, 8);
            $name = 'content-' . mb_strtolower($key);
            $headers->set($name, $value);
        }
    }

    /**
     * Checks if a header starts with HTTP_ and adds it to the collection
     *
     * @param string     $key
     * @param mixed      $value
     * @param Collection $headers
     */
    private function checkHttpHeader(string $key, $value, Collection $headers): void
    {
        if (mb_strpos($key, 'HTTP_') === 0) {
            $name = str_replace(
                '_',
                '-',
                mb_strtolower(substr($key, 5))
            );
            $headers->set($name, $value);
        }
    }

    /**
     * Parse a cookie header according to RFC 6265.
     *
     * @param string $cookieHeader A string cookie header value.
     *
     * @return array key/value cookie pairs.
     *
     */
    private function parseCookieHeader($cookieHeader): array
    {
        $cookies = [];
        parse_str(
            strtr(
                $cookieHeader,
                [
                    '&' => '%26',
                    '+' => '%2B',
                    ';' => '&',
                ]
            ),
            $cookies
        );

        return $cookies;
    }

    /**
     * Processes headers from SAPI
     *
     * @param Collection $server
     *
     * @return Collection
     */
    private function parseHeaders(Collection $server): Collection
    {
        $headers = new Collection();
        foreach ($server as $key => $value) {
            if ('' !== $value) {
                /**
                 * Apache prefixes environment variables with REDIRECT_
                 * if they are added by rewrite rules
                 */
                if (mb_strpos($key, 'REDIRECT_') === 0) {
                    $key = (string) substr($key, 9);
                    /**
                     * We will not overwrite existing variables with the
                     * prefixed versions, though
                     */
                    if ($server->has($key)) {
                        continue;
                    }
                }

                $this->checkHttpHeader($key, $value, $headers);
                $this->checkContentHeader($key, $value, $headers);
            }
        }

        return $headers;
    }

    /**
     * Parse the $_SERVER array amd return it back after looking for the
     * authorization header
     *
     * @param array $server Either verbatim, or with an added
     *                      HTTP_AUTHORIZATION header.
     *
     * @return Collection
     */
    private function parseServer(array $server): Collection
    {
        $collection = new Collection($server);
        $headers    = $this->getHeaders();

        if (true !== $collection->has("HTTP_AUTHORIZATION") && false !== $headers) {
            $headersCollection = new Collection($headers);

            if ($headersCollection->has('Authorization')) {
                $collection->set(
                    'HTTP_AUTHORIZATION',
                    $headersCollection->get('Authorization')
                );
            }
        }

        return $collection;
    }
}

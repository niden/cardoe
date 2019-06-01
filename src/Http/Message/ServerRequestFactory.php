<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message;

use Cardoe\Collection\Collection;
use Cardoe\Helper\Arr;
use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriInterface;
use function apache_request_headers;
use function explode;
use function function_exists;
use function implode;
use function is_array;
use function is_bool;
use function is_string;
use function ltrim;
use function mb_strtolower;
use function preg_match;
use function preg_replace;
use function strlen;
use function strpos;
use function strrpos;
use function strtolower;
use function substr;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
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
        array $server = null,
        array $get = null,
        array $post = null,
        array $cookies = null,
        array $files = null
    ): ServerRequest {
        $server  = $server ?: $_SERVER;
        $files   = $files ?: $_FILES;
        $cookies = $cookies ?: $_COOKIE;
        $get     = $get ?: $_GET;
        $post    = $post ?: $_POST;

        $method   = Arr::get($server, 'REQUEST_METHOD', 'GET');
        $protocol = Arr::get($server, 'SERVER_PROTOCOL', '1.1');

        $server  = $this->parseServer($server);
        $headers = $this->parseHeaders($server);
        $files   = $this->parseUploadedFiles($files);

        if (true === empty($cookies) && $headers->has('cookie')) {
            $cookies = $this->parseCookieHeader($headers->get('cookie'));
        }

        return new ServerRequest(
            $method,
            $this->parseUri($server, $headers),
            $server->toArray(),
            'php://input',
            $headers,
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
     * @return array|bool
     */
    protected function getHeaders()
    {
        if (true === function_exists('apache_request_headers')) {
            return apache_request_headers();
        }

        return false;
    }

    /**
     * Calculates the host and port from the headers or the server superglobal
     *
     * @param Collection $server
     * @param Collection $headers
     *
     * @return array
     */
    private function calculateUriHost(Collection $server, Collection $headers): array
    {
        $return = ['', null];

        if (false !== $this->getHeader($headers, 'host', false)) {
            $host = $this->getHeader($headers, 'host');
            return $this->calculateUriHostFromHeader($host);
        }

        if (true !== $server->has('SERVER_NAME')) {
            return $return;
        }

        $host = $server->get('SERVER_NAME');
        $port = $server->get('SERVER_PORT', null);

        return [$host, $port];
    }

    /**
     * Get the host and calculate the port if present from the header
     *
     * @param string $host
     *
     * @return array
     */
    private function calculateUriHostFromHeader(string $host): array
    {
        $port = null;

        // works for regname, IPv4 & IPv6
        if (preg_match('|:(\d+)$|', $host, $matches)) {
            $host = substr($host, 0, -1 * (strlen($matches[1]) + 1));
            $port = (int) $matches[1];
        }

        return [$host, $port];
    }

    /**
     * Get the path from the request from IIS7/Rewrite, REQUEST_URL or
     * ORIG_PATH_INFO
     *
     * @param Collection $server
     *
     * @return string
     */
    private function calculateUriPath(Collection $server): string
    {
        /**
         * IIS7 with URL Rewrite - double slash
         */
        $iisRewrite   = $server->get('IIS_WasUrlRewritten', null);
        $unencodedUrl = $server->get('UNENCODED_URL', '');

        if ('1' === $iisRewrite && true !== empty($unencodedUrl)) {
            return $unencodedUrl;
        }

        /**
         * REQUEST_URI
         */
        $requestUri = $server->get('REQUEST_URI', null);

        if (null !== $requestUri) {
            return preg_replace('#^[^/:]+://[^/]+#', '', $requestUri);
        }

        /**
         * ORIG_PATH_INFO
         */
        $origPathInfo = $server->get('ORIG_PATH_INFO', null);
        if (true === empty($origPathInfo)) {
            return '/';
        }

        return $origPathInfo;
    }

    /**
     * Get the query string from the server array
     *
     * @param Collection $server
     *
     * @return string
     */
    private function calculateUriQuery(Collection $server): string
    {
        return ltrim($server->get('QUERY_STRING', ''), '?');
    }

    /**
     * Calculates the scheme from the server variables
     *
     * @param Collection $server
     * @param Collection $headers
     *
     * @return string
     */
    private function calculateUriScheme(Collection $server, Collection $headers): string
    {
        // URI scheme
        $scheme  = 'https';
        $isHttps = true;
        if (true === $server->has('HTTPS')) {
            $isHttps = $server->get('HTTPS', 'on');
            if (true !== is_string($isHttps) && true !== is_bool($isHttps)) {
                throw new InvalidArgumentException(
                    'HTTPS value must be a string or boolean'
                );
            }

            if (true === is_string($isHttps)) {
                $isHttps = 'off' !== mb_strtolower($isHttps);
            }
        }

        $header = $this->getHeader($headers, 'x-forwarded-proto', 'https');
        if (true !== $isHttps || 'https' !== $header) {
            $scheme = 'http';
        }

        return $scheme;
    }

    /**
     * Create an UploadedFile object from an $_FILES array element
     *
     * @param array $file The $_FILES element
     *
     * @return UploadedFile
     *
     * @throws InvalidArgumentException If one of the elements is missing
     */
    private function createUploadedFile(array $file): UploadedFile
    {
        if (true !== isset($file['tmp_name']) ||
            true !== isset($file['size']) ||
            true !== isset($file['error'])
        ) {
            throw new InvalidArgumentException(
                'The file array must contain tmp_name, size and error; ' .
                'one or more are missing'
            );
        }

        return new UploadedFile(
            $file['tmp_name'],
            $file['size'],
            $file['error'],
            isset($file['name']) ? $file['name'] : null,
            isset($file['type']) ? $file['type'] : null
        );
    }

    /**
     * Returns a header
     *
     * @param Collection $headers
     * @param string     $name
     * @param mixed|null $defaultValue
     *
     * @return mixed|string
     */
    private function getHeader(Collection $headers, string $name, $defaultValue = null)
    {
        $value = $headers->get($name, $defaultValue);

        if (true === is_array($value)) {
            $value = implode(',', $value);
        }

        return $value;
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
            /**
             * Apache prefixes environment variables with REDIRECT_
             * if they are added by rewrite rules
             */
            if (strpos($key, 'REDIRECT_') === 0) {
                $key = substr($key, 9);
                /**
                 * We will not overwrite existing variables with the
                 * prefixed versions, though
                 */
                if (true === $server->has($key)) {
                    continue;
                }
            }

            if ($value === '') {
                continue;
            }

            if (strpos($key, 'HTTP_') === 0) {
                $name = strtr(strtolower(substr($key, 5)), '_', '-');
                $headers->set($name, $value);
                continue;
            }

            if (strpos($key, 'CONTENT_') === 0) {
                $name = 'content-' . strtolower(substr($key, 8));
                $headers->set($name, $value);
                continue;
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

        if (true !== isset($server['HTTP_AUTHORIZATION']) && false !== $headers) {
            $headers = new Collection($headers);
            if (true === $headers->has('Authorization')) {
                $collection->set('HTTP_AUTHORIZATION', $headers->get('Authorization'));
            }
        }

        return $collection;
    }

    /**
     * Traverses a $_FILES and creates UploadedFile objects from it. It is used
     * recursively
     *
     * @param array $files
     *
     * @return Collection
     */
    private function parseUploadedFiles(array $files): Collection
    {
        $collection = new Collection();

        /**
         * Loop through the files and check them recursively
         */
        foreach ($files as $key => $file) {
            $key = (string) $key;

            /**
             * UriInterface
             */
            if ($file instanceof UploadedFileInterface) {
                $collection->set($key, $file);
                continue;
            }

            /**
             * file is array with 'tmp_name'
             */
            if (true === is_array($file) && true === isset($file['tmp_name'])) {
                $collection->set($key, $this->createUploadedFile($file));
                continue;
            }

            /**
             * file is array of elements - recursion
             */
            if (true === is_array($file)) {
                $data = $this->parseUploadedFiles($file);
                $collection->set($key, $data->toArray());
                continue;
            }
        }

        return $collection;
    }

    /**
     * Calculates the Uri from the server superglobal or the headers
     *
     * @param Collection $server
     * @param Collection $headers
     *
     * @return Uri
     */
    private function parseUri(Collection $server, Collection $headers): Uri
    {
        $uri = new Uri('');

        /**
         * Scheme
         */
        $scheme = $this->calculateUriScheme($server, $headers);
        $uri    = $uri->withScheme($scheme);

        /**
         * Host/Port
         */
        [$host, $port] = $this->calculateUriHost($server, $headers);
        if (true !== empty($host)) {
            $uri = $uri->withHost($host);
            if (true !== empty($port)) {
                $uri = $uri->withPort($port);
            }
        }

        /**
         * Path
         */
        $path  = $this->calculateUriPath($server);
        $split = explode('#', $path);
        $path  = explode('?', $split[0]);
        $uri   = $uri->withPath($path[0]);

        if (count($split) > 1) {
            /**
             * Fragment
             */
            $uri = $uri->withFragment($split[1]);
        }


        /**
         * Query
         */
        $query = $this->calculateUriQuery($server);
        $uri   = $uri->withQuery($query);

        return $uri;
    }
}

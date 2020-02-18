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
 * @link    https://github.com/zendframework/zend-diactoros
 * @license https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Phalcon\Collection;
use Phalcon\Helper\Arr;
use Phalcon\Http\Message\Exception\InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\UploadedFileInterface;

use function is_array;
use function is_object;

/**
 * PSR-17 ServerRequestFactory
 */
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
        $globalCookies = [];
        $globalFiles   = [];
        $globalGet     = [];
        $globalPost    = [];
        $globalServer  = [];

        /**
         * Ensure that superglobals are defined if not
         */
        if (!empty($_COOKIE)) {
            $globalCookies = $_COOKIE;
        }

        if (!empty($_FILES)) {
            $globalFiles = $_FILES;
        }

        if (!empty($_GET)) {
            $globalGet = $_GET;
        }

        if (!empty($_POST)) {
            $globalPost = $_POST;
        }

        if (!empty($_SERVER)) {
            $globalServer = $_SERVER;
        }

        $server            = $this->checkNullArray($server, $globalServer);
        $files             = $this->checkNullArray($files, $globalFiles);
        $cookies           = $this->checkNullArray($cookies, $globalCookies);
        $get               = $this->checkNullArray($get, $globalGet);
        $post              = $this->checkNullArray($post, $globalPost);
        $serverCollection  = $this->parseServer($server);
        /** @var string $method */
        $method            = $serverCollection->get(
            "REQUEST_METHOD",
            "GET",
            "string"
        );
        $protocol          = $this->parseProtocol($serverCollection);
        $headers           = $this->parseHeaders($serverCollection);
        $filesCollection   = $this->parseUploadedFiles($files);
        $cookiesCollection = $cookies;

        if (empty($cookies) && $headers->has("cookie")) {
            $cookieHeader      = (string) $headers->get("cookie");
            $cookiesCollection = $this->parseCookieHeader($cookieHeader);
        }

        return new ServerRequest(
            $method,
            $this->parseUri($serverCollection, $headers),
            $serverCollection->toArray(),
            "php://input",
            $headers->toArray(),
            $cookiesCollection,
            $get,
            $filesCollection->toArray(),
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
        if (function_exists("apache_request_headers")) {
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
    private function calculateUriHost(
        Collection $server,
        Collection $headers
    ): array {
        $defaults = ["", null];

        if ($this->getHeader($headers, "host", false)) {
            $host = $this->getHeader($headers, "host");

            return $this->calculateUriHostFromHeader($host);
        }

        if (!$server->has("SERVER_NAME")) {
            return $defaults;
        }

        $host = $server->get("SERVER_NAME");
        $port = $server->get("SERVER_PORT", null);

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
        if (preg_match("|:(\d+)$|", $host, $matches)) {
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
        $iisRewrite   = $server->get("IIS_WasUrlRewritten", null);
        $unencodedUrl = $server->get("UNENCODED_URL", "");

        if ("1" === $iisRewrite && !empty($unencodedUrl)) {
            return $unencodedUrl;
        }

        /**
         * REQUEST_URI
         */
        $requestUri = $server->get("REQUEST_URI", null);

        if (null !== $requestUri) {
            return preg_replace(
                "#^[^/:]+://[^/]+#",
                "",
                $requestUri
            );
        }

        /**
         * ORIG_PATH_INFO
         */
        $origPathInfo = $server->get("ORIG_PATH_INFO", null);
        if (empty($origPathInfo)) {
            return "/";
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
        return ltrim($server->get("QUERY_STRING", ""), "?");
    }

    /**
     * Calculates the scheme from the server variables
     *
     * @param Collection $server
     * @param Collection $headers
     *
     * @return string
     */
    private function calculateUriScheme(
        Collection $server,
        Collection $headers
    ): string {
        // URI scheme
        $scheme  = "https";
        $isHttps = true;
        if ($server->has("HTTPS")) {
            $isHttps = (string) $server->get("HTTPS", "on");
            $isHttps = "off" !== strtolower($isHttps);
        }

        $header = $this->getHeader($headers, "x-forwarded-proto", "https");
        if (!$isHttps || "https" !== $header) {
            $scheme = "http";
        }

        return $scheme;
    }

    /**
     * Checks the source if it null and returns the super, otherwise the source
     * array
     *
     * @param mixed $source
     * @param array $super
     *
     * @return array
     */
    private function checkNullArray($source, array $super): array
    {
        if (null === $source) {
            return $super;
        }

        return $source;
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
        if (
            !isset($file["tmp_name"]) ||
            !isset($file["size"]) ||
            !isset($file["error"])
        ) {
            throw new InvalidArgumentException(
                "The file array must contain tmp_name, size and error; " .
                "one or more are missing"
            );
        }

        $name = Arr::get($file, "name");
        $type = Arr::get($file, "type");

        return new UploadedFile(
            $file["tmp_name"],
            $file["size"],
            $file["error"],
            $name,
            $type
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
    private function getHeader(
        Collection $headers,
        string $name,
        $defaultValue = null
    ) {
        $value = $headers->get($name, $defaultValue);

        if (is_array($value)) {
            $value = implode(",", $value);
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
    private function parseCookieHeader(string $cookieHeader): array
    {
        $cookies = [];
        parse_str(
            strtr(
                $cookieHeader,
                [
                    "&" => "%26",
                    "+" => "%2B",
                    ";" => "&"
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
        /**
         * @todo Figure out why server is not iterable
         */
        $headers     = new Collection();
        $serverArray = $server->toArray();

        foreach ($serverArray as $key => $value) {
            if ("" !== $value) {
                /**
                 * Apache prefixes environment variables with REDIRECT_
                 * if they are added by rewrite rules
                 */
                if (strpos($key, "REDIRECT_") === 0) {
                    $key = substr($key, 9);

                    /**
                     * We will not overwrite existing variables with the
                     * prefixed versions, though
                     */
                    if (true === $server->has($key)) {
                        continue;
                    }
                }

                if (strpos($key, "HTTP_") === 0) {
                    $name = str_replace(
                        "_",
                        "-",
                        strtolower(substr($key, 5))
                    );

                    $headers->set($name, $value);
                    continue;
                }

                if (strpos($key, "CONTENT_") === 0) {
                    $name = "content-" . strtolower(substr($key, 8));

                    $headers->set($name, $value);
                    continue;
                }
            }
        }

        return $headers;
    }

    /**
     * Parse the $_SERVER array amd check the server protocol. Raise an
     *
     * @param Collection $server The server variables
     *
     * @return string
     */
    private function parseProtocol(Collection $server): string
    {
        if (true !== $server->has("SERVER_PROTOCOL")) {
            return "1.1";
        }

        $protocol      = (string) $server->get("SERVER_PROTOCOL", "HTTP/1.1");
        $localProtocol = strtolower($protocol);
        $protocols     = [
            "1.0" => 1,
            "1.1" => 1,
            "2.0" => 1,
            "3.0" => 1
        ];

        if (substr($localProtocol, 0, 5) !== "http/") {
            throw new InvalidArgumentException(
                "Incorrect protocol value " . $protocol
            );
        }

        $localProtocol = str_replace("http/", "", $localProtocol);

        if (!isset($protocols[$localProtocol])) {
            throw new InvalidArgumentException(
                "Unsupported protocol " . $protocol
            );
        }

        return $localProtocol;
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

        if (!$collection->has("HTTP_AUTHORIZATION") && false !== $headers) {
            $headersCollection = new Collection($headers);

            if ($headersCollection->has("Authorization")) {
                $collection->set(
                    "HTTP_AUTHORIZATION",
                    $headersCollection->get("Authorization")
                );
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
            if (is_object($file) && $file instanceof UploadedFileInterface) {
                $collection->set($key, $file);
                continue;
            }

            /**
             * file is array with 'tmp_name'
             */
            if (is_array($file) && isset($file["tmp_name"])) {
                $collection->set($key, $this->createUploadedFile($file));
                continue;
            }

            /**
             * file is array of elements - recursion
             */
            if (is_array($file)) {
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
        $uri = new Uri();

        /**
         * Scheme
         */
        $scheme = $this->calculateUriScheme($server, $headers);
        $uri    = $uri->withScheme($scheme);

        /**
         * Host/Port
         */
        $split = $this->calculateUriHost($server, $headers);
        if (!empty($split[0])) {
            $uri = $uri->withHost($split[0]);
            if (!empty($split[1])) {
                $uri = $uri->withPort($split[1]);
            }
        }

        /**
         * Path
         */
        $path  = $this->calculateUriPath($server);
        $split = explode("#", $path);
        $path  = explode("?", $split[0]);
        $uri   = $uri->withPath($path[0]);

        if (count($split) > 1) {
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

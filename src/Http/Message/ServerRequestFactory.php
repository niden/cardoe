<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message;

use Cardoe\Helper\Arr;
use Cardoe\Http\Message\Traits\ServerRequestFactoryTrait;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use function apache_request_headers;
use function function_exists;

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
     * @return array|bool
     */
    protected function getHeaders()
    {
        if (true === function_exists('apache_request_headers')) {
            return apache_request_headers();
        }

        return false;
    }
}

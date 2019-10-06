<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Transport;

use Cardoe\Http\Client\Exception\NetworkException;
use Cardoe\Http\Client\Request\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function array_shift;
use function curl_close;
use function curl_errno;
use function curl_error;
use function curl_exec;
use function curl_init;
use function curl_setopt_array;
use function explode;
use function fclose;
use function fopen;
use function strlen;
use function trim;
use const CURL_HTTP_VERSION_1_0;
use const CURL_HTTP_VERSION_1_1;
use const CURL_HTTP_VERSION_2_0;
use const CURLOPT_CONNECTTIMEOUT;
use const CURLOPT_CUSTOMREQUEST;
use const CURLOPT_FILE;
use const CURLOPT_FOLLOWLOCATION;
use const CURLOPT_HEADER;
use const CURLOPT_HEADERFUNCTION;
use const CURLOPT_HTTP_VERSION;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_POSTFIELDS;
use const CURLOPT_RETURNTRANSFER;

/**
 * Class Curl
 */
class Curl extends AbstractTransport
{
    /**
     * @inheritdoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $resource = fopen('php://temp', 'wb');

        $curlOptions = [
            CURLOPT_CUSTOMREQUEST  => $request->getMethod(),
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_FOLLOWLOCATION => $this->options['follow'],
            CURLOPT_HEADER         => false,
            CURLOPT_CONNECTTIMEOUT => $this->options['timeout'],
            CURLOPT_FILE           => $resource,
        ];

        $version = $request->getProtocolVersion();
        switch ($version) {
            case "1.0":
                $curlOptions[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_0;
                break;

            case "2.0":
                $curlOptions[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2_0;
                break;

            case "1.1":
            default:
                $curlOptions[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
                break;
        }

        $curlOptions[CURLOPT_HTTPHEADER] = explode(
            "\r\n",
            $this->serializeHeaders($request->getHeaders())
        );

        if (null !== $request->getBody()->getSize()) {
            $curlOptions[CURLOPT_POSTFIELDS] = $request->getBody()->__toString();
        }

        $headers = [];

        $curlOptions[CURLOPT_HEADERFUNCTION] = function ($resource, $headerString) use (&$headers) {
            $header = trim($headerString);
            if (strlen($header) > 0) {
                $headers[] = $header;
            }

            return mb_strlen($headerString, '8bit');
        };

        $curlResource = curl_init($request->getUri()->__toString());

        if (false === $curlResource) {
            throw new NetworkException(
                'curl could not open the URI',
                $request
            );
        }

        curl_setopt_array($curlResource, $curlOptions);
        curl_exec($curlResource);

        $stream = $this->resourceToStream(
            $resource,
            $this->streamFactory,
            $request
        );

        if ($this->options['follow']) {
            $headers = $this->filterHeaders($headers);
        }

        fclose($resource);

        $errorNumber  = curl_errno($curlResource);
        $errorMessage = curl_error($curlResource);

        if ($errorNumber) {
            throw new NetworkException($errorMessage, $request);
        }

        $parts   = explode(' ', array_shift($headers), 3);
        $version = explode('/', $parts[0])[1];
        $status  = (int) $parts[1];

        curl_close($curlResource);

        $response = $this->responseFactory->createResponse($status)
                                          ->withProtocolVersion($version)
                                          ->withBody($stream)
        ;

        $headers = $this->unserializeHeaders($headers);
        foreach ($headers as $key => $value) {
            $response = $response->withHeader($key, $value);
        }

        return $response;
    }

    /**
     * @inheritdoc
     */
    public function process(
        RequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return $this->sendRequest($request);
    }
}

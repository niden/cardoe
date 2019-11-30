<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client\Transport;

use Cardoe\Http\Client\Exception\NetworkException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Curl extends AbstractTransport
{
    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $version  = $request->getProtocolVersion();
        $resource = fopen("php://temp", "wb");
        $options  = [
            CURLOPT_CUSTOMREQUEST  => $request->getMethod(),
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_FOLLOWLOCATION => $this->options["followLocation"],
            CURLOPT_HEADER         => false,
            CURLOPT_CONNECTTIMEOUT => $this->options["timeout"],
            CURLOPT_FILE           => $resource,
        ];

        switch ($version) {
            case "1.0":
                $options[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_0;
                break;

            case "2.0":
                $options[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2_0;
                break;

            case "1.1":
            default:
                $options[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
                break;
        }

        $options[CURLOPT_HTTPHEADER] = explode(
            "\r\n",
            $this->serializeHeaders($request->getHeaders())
        );

        if ($request->getBody()->getSize()) {
            $options[CURLOPT_POSTFIELDS] = $request->getBody()->__toString();
        }

        $headers = [];

        $options[CURLOPT_HEADERFUNCTION] = function ($resource, $headerString) use (&$headers) {
            $header = trim($headerString);
            if (strlen($header) > 0) {
                $headers[] = $header;
            }

            return mb_strlen($headerString, "8bit");
        };

        $curlResource = curl_init($request->getUri()->__toString());
        curl_setopt_array($curlResource, $options);
        curl_exec($curlResource);

        $stream = $this->resourceToStream($resource, $this->streamFactory, $request);

        if ($this->options["followLocation"]) {
            $headers = $this->filterHeaders($headers);
        }

        fclose($resource);

        $errorNumber  = curl_errno($curlResource);
        $errorMessage = curl_error($curlResource);

        if ($errorNumber) {
            throw new NetworkException($errorMessage, $request);
        }

        $parts   = explode(" ", array_shift($headers), 3);
        $version = explode("/", $parts[0])[1];
        $status  = (int) $parts[1];

        curl_close($curlResource);

        $response = $this
            ->responseFactory
            ->createResponse($status)
            ->withProtocolVersion($version)
            ->withBody($stream)
        ;

        $unserialized = $this->unserializeHeaders($headers);
        foreach ($unserialized as $key => $value) {
            $response = $response->withHeader($key, $value);
        }

        return $response;
    }
}

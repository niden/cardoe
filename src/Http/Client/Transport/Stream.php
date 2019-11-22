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
use Cardoe\Http\Client\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Stream
 *
 * @package Cardoe\Http\Client\Transport
 */
class Stream extends AbstractTransport
{
    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $context = [
            "http" => [
                "method"           => $request->getMethod(),
                "header"           => $this->serializeHeaders($request->getHeaders()),
                "protocol_version" => $request->getProtocolVersion(),
                "ignore_errors"    => true,
                "timeout"          => $this->options["timeout"],
                "follow_location"  => $this->options["followLocation"],
            ],
        ];

        if ($request->getBody()->getSize()) {
            $context["http"]["content"] = $request->getBody()->__toString();
        }

        $resource = fopen(
            $request->getUri()->__toString(),
            "rb",
            false,
            stream_context_create($context)
        );

        if (!is_resource($resource)) {
            $error = error_get_last()["message"];
            if (strpos($error, "getaddrinfo") ||
                strpos($error, "Connection refused")) {
                $ex = new NetworkException($error, $request);
            } else {
                $ex = new RequestException($error, $request);
            }

            throw $ex;
        }

        $stream  = $this->resourceToStream($resource, $this->streamFactory, $request);
        $headers = stream_get_meta_data($resource)["wrapper_data"] ?? [];

        if ($this->options["followLocation"]) {
            $headers = $this->filterHeaders($headers);
        }

        fclose($resource);

        $parts   = explode(" ", array_shift($headers), 3);
        $version = explode("/", $parts[0])[1];
        $status  = (int) $parts[1];

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

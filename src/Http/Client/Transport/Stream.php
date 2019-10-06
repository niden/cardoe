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
use Cardoe\Http\Client\Request\HandlerInterface;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function strpos;

/**
 * Class Stream
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
            'http' => [
                'method'           => $request->getMethod(),
                'header'           => $this->serializeHeaders($request->getHeaders()),
                'protocol_version' => $request->getProtocolVersion(),
                'ignore_errors'    => true,
                'timeout'          => $this->options['timeout'],
                'follow_location'  => $this->options['follow'],
            ],
        ];

        if (null !== $request->getBody()->getSize()) {
            $context['http']['content'] = $request->getBody()->__toString();
        }

        try {
            $resource = fopen(
                $request->getUri()->__toString(),
                'rb',
                false,
                stream_context_create($context)
            );
        } catch (Exception $ex) {
            if (strpos($ex->getMessage(), 'getaddrinfo') ||
                strpos($ex->getMessage(), 'Connection refused')) {
                throw new NetworkException($ex->getMessage(), $request);
            } else {
                throw new RequestException($ex->getMessage(), $request);
            }
        }

        $stream  = $this->resourceToStream(
            $resource,
            $this->streamFactory,
            $request
        );
        $headers = stream_get_meta_data($resource)['wrapper_data'] ?? [];

        if ($this->options['follow']) {
            $headers = $this->filterHeaders($headers);
        }

        fclose($resource);

        $parts   = explode(' ', array_shift($headers), 3);
        $version = explode('/', $parts[0])[1];
        $status  = (int) $parts[1];

        $response = $this
            ->responseFactory
            ->createResponse($status)
            ->withProtocolVersion($version)
            ->withBody($stream)
        ;

        $headers = $this->unserializeHeaders($headers);
        foreach ($headers as $key => $value) {
            $response = $response->withHeader($key, $value);
        }

        return $response;
    }

    public function process(
        RequestInterface $request,
        HandlerInterface $handler
    ): ResponseInterface {
        return $this->sendRequest($request);
    }
}

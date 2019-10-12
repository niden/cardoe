<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Transport;

use Cardoe\Http\Client\Exception\Exception;
use Cardoe\Http\Message\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use function extension_loaded;

/**
 * Class Curl
 */
class Curl extends AbstractTransport
{
    /**
     * Curl constructor.
     *
     * @param StreamFactoryInterface   $streamFactory
     * @param ResponseFactoryInterface $responseFactory
     * @param array                    $options
     *
     * @throws Exception
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        array $options = []
    ) {
        if (true !== extension_loaded('curl')) {
            throw new Exception(
                'curl extension must be loaded for this transport to work'
            );
        }

        parent::__construct($streamFactory, $responseFactory, $options);
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function process(RequestInterface $request): ResponseInterface
    {
        return new Response();
    }
}

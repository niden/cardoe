<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client;

use Cardoe\Http\Client\Middleware\Deflate;
use Cardoe\Http\Client\Middleware\UserAgent;
use Cardoe\Http\Client\Transport\Curl;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class ClientFactory
 *
 * @package Cardoe\Http\Client
 */
class ClientFactory
{
    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param StreamFactoryInterface   $streamFactory
     * @param array                    $options
     *
     * @return ClientInterface
     */
    public function newInstance(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        array $options = []
    ): ClientInterface {
        return new Client(
            [
                new UserAgent(),
                new Deflate($streamFactory),
                new Curl($streamFactory, $responseFactory, $options),
            ],
            $responseFactory
        );
    }
}

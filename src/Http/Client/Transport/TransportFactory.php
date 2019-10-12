<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Transport;

use Cardoe\Factory\AbstractFactory;
use Cardoe\Factory\Exception as FactoryException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class TransportFactory
 *
 * @package Cardoe\Http\Client\Transport
 */
class TransportFactory extends AbstractFactory
{
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * TransportFactory constructor.
     *
     * @param StreamFactoryInterface   $streamFactory
     * @param ResponseFactoryInterface $responseFactory
     * @param array                    $services
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        array $services = []
    ) {
        $this->init($services);
        $this->streamFactory   = $streamFactory;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Create a new instance of the adapter
     *
     * @param string $name
     * @param array  $options
     *
     * @return ClientInterface
     * @throws FactoryException
     */
    public function newInstance(
        string $name,
        array $options = []
    ): TransportInterface {
        $this->checkService($name);

        if (true !== isset($this->services[$name])) {
            $definition            = $this->mapper[$name];
            $this->services[$name] = new $definition(
                $this->streamFactory,
                $this->responseFactory,
                $options
            );
        }

        return $this->services[$name];
    }

    /**
     * @return array
     */
    protected function getAdapters(): array
    {
        return [
            "curl"   => Curl::class,
            "stream" => Stream::class,
        ];
    }
}

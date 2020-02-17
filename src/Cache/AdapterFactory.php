<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Cache;

use Phalcon\Cache\Adapter\AdapterInterface;
use Phalcon\Factory\AbstractFactory;
use Phalcon\Factory\Exception as FactoryException;
use Phalcon\Storage\SerializerFactory;

/**
 * Factory to create Cache adapters
 *
 * @property SerializerFactory $serializerFactory
 */
class AdapterFactory extends AbstractFactory
{
    /**
     * @var SerializerFactory
     */
    private $serializerFactory;

    /**
     * AdapterFactory constructor.
     *
     * @param SerializerFactory|null $factory
     * @param array                  $services
     */
    public function __construct(
        SerializerFactory $factory = null,
        array $services = []
    ) {
        $this->serializerFactory = $factory;

        $this->init($services);
    }

    /**
     * Create a new instance of the adapter
     *
     * @param string $name
     * @param array  $options = [
     *                        'servers' => [
     *                        [
     *                        'host'   => 'localhost',
     *                        'port'   => 11211,
     *                        'weight' => 1,
     *                        ]
     *                        ],
     *                        'host'              => '127.0.0.1',
     *                        'port'              => 6379,
     *                        'index'             => 0,
     *                        'persistent'        => false,
     *                        'auth'              => '',
     *                        'socket'            => '',
     *                        'defaultSerializer' => 'Php',
     *                        'lifetime'          => 3600,
     *                        'prefix'            => 'phalcon',
     *                        'storageDir'        => ''
     *                        ]
     *
     * @return AdapterInterface
     * @throws FactoryException
     */
    public function newInstance(
        string $name,
        array $options = []
    ): AdapterInterface {
        $this->checkService($name);

        $definition = $this->mapper[$name];

        return new $definition($this->serializerFactory, $options);
    }

    /**
     * Returns the available adapters
     *
     * @return array|string[]
     */
    protected function getAdapters(): array
    {
        return [
            "apcu"         => "Phalcon\\Cache\\Adapter\\Apcu",
            "libmemcached" => "Phalcon\\Cache\\Adapter\\Libmemcached",
            "memory"       => "Phalcon\\Cache\\Adapter\\Memory",
            "redis"        => "Phalcon\\Cache\\Adapter\\Redis",
            "stream"       => "Phalcon\\Cache\\Adapter\\Stream",
        ];
    }
}

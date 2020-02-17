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

namespace Phalcon\Storage;

use Phalcon\Factory\AbstractFactory;
use Phalcon\Factory\Exception as ExceptionAlias;
use Phalcon\Storage\Adapter\AdapterInterface;

/**
 * Class AdapterFactory
 *
 * @property SerializerFactory $serializerFactory
 */
class AdapterFactory extends AbstractFactory
{
    /**
     * @var SerializerFactory|null
     */
    private $serializerFactory;

    /**
     * AdapterFactory constructor.
     *
     * @param SerializerFactory $factory
     * @param array             $services
     */
    public function __construct(SerializerFactory $factory, array $services = [])
    {
        $this->serializerFactory = $factory;

        $this->init($services);
    }

    /**
     * Create a new instance of the adapter
     *
     * @param string $name
     * @param array options = [
     *             'servers' => [
     *             [
     *             'host'   => '127.0.0.1',
     *             'port'   => 11211,
     *             'weight' => 1
     *             ]
     *             ],
     *             'defaultSerializer' => 'Php',
     *             'lifetime'          => 3600,
     *             'prefix'            => '',
     *             'host'              => '127.0.0.1',
     *             'port'              => 6379,
     *             'index'             => 0,
     *             'persistent'        => false,
     *             'auth'              => '',
     *             'socket'            => '',
     *             'storageDir'        => '',
     *             ]
     *
     * @return AdapterInterface
     * @throws ExceptionAlias
     */
    public function newInstance(string $name, array $options = []): AdapterInterface
    {
        $this->checkService($name);

        $definition = $this->mapper[$name];

        return new $definition($this->serializerFactory, $options);
    }

    /**
     * @return array
     */
    protected function getAdapters(): array
    {
        return [
            "apcu"         => 'Phalcon\Storage\Adapter\Apcu',
            "libmemcached" => 'Phalcon\Storage\Adapter\Libmemcached',
            "memory"       => 'Phalcon\Storage\Adapter\Memory',
            "redis"        => 'Phalcon\Storage\Adapter\Redis',
            "stream"       => 'Phalcon\Storage\Adapter\Stream',
        ];
    }
}

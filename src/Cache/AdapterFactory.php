<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Cache;

use Phalcon\Cache\Adapter\AdapterInterface;
use Phalcon\Factory\AbstractFactory;
use Phalcon\Factory\Exception;
use Phalcon\Storage\SerializerFactory;

/**
 * Factory to create Cache adapters
 *
 * @property SerializerFactory|null $serializerFactory
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
     * @param SerializerFactory|null $factory
     * @param array                  $services
     */
    public function __construct(SerializerFactory $factory = null, array $services = [])
    {
        $this->serializerFactory = $factory;

        $this->init($services);
    }

    /**
     * Create a new instance of the adapter
     *
     * @param string $name
     * @param array  $options
     *
     * @return AdapterInterface
     * @throws Exception
     */
    public function newInstance(string $name, array $options = []): AdapterInterface
    {
        $this->checkService($name);

        $definition = $this->mapper[$name];

        return new $definition($this->serializerFactory, $options);
    }

    /**
     * Returns the available adapters
     */
    protected function getAdapters(): array
    {
        return [
            "apcu"         => 'Phalcon\Cache\Adapter\Apcu',
            "libmemcached" => 'Phalcon\Cache\Adapter\Libmemcached',
            "memory"       => 'Phalcon\Cache\Adapter\Memory',
            "redis"        => 'Phalcon\Cache\Adapter\Redis',
            "stream"       => 'Phalcon\Cache\Adapter\Stream',
        ];
    }
}

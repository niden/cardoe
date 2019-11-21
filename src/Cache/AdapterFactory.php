<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Cache;

use Cardoe\Cache\Adapter\AdapterInterface;
use Cardoe\Cache\Adapter\Apcu;
use Cardoe\Cache\Adapter\Libmemcached;
use Cardoe\Cache\Adapter\Memory;
use Cardoe\Cache\Adapter\Redis;
use Cardoe\Cache\Adapter\Stream;
use Cardoe\Factory\AbstractFactory;
use Cardoe\Factory\Exception;
use Cardoe\Storage\SerializerFactory;

/**
 * Factory to create Cache adapters
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

        if (true !== isset($this->services[$name])) {
            $definition            = $this->mapper[$name];
            $this->services[$name] = new $definition($this->serializerFactory, $options);
        }

        return $this->services[$name];
    }

    /**
     * Returns the available adapters
     */
    protected function getAdapters(): array
    {
        return [
            "apcu"         => Apcu::class,
            "libmemcached" => Libmemcached::class,
            "memory"       => Memory::class,
            "redis"        => Redis::class,
            "stream"       => Stream::class,
        ];
    }
}

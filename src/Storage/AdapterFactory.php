<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Storage;

use Phalcon\Factory\AbstractFactory;
use Phalcon\Factory\Exception as ExceptionAlias;
use Phalcon\Storage\Adapter\AdapterInterface;
use Phalcon\Storage\Adapter\Apcu;
use Phalcon\Storage\Adapter\Libmemcached;
use Phalcon\Storage\Adapter\Memory;
use Phalcon\Storage\Adapter\Redis;
use Phalcon\Storage\Adapter\Stream;

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
     * @throws ExceptionAlias
     */
    public function newInstance(string $name, array $options = []): AdapterInterface
    {
        $this->checkService($name);

        if (!isset($this->services[$name])) {
            $definition            = $this->mapper[$name];
            $this->services[$name] = new $definition($this->serializerFactory, $options);
        }

        return $this->services[$name];
    }

    /**
     * @return array
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

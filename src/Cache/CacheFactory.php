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

use Phalcon\Cache;
use Phalcon\Cache\Exception\Exception;
use Phalcon\Config;
use Phalcon\Factory\Exception as FactoryException;
use Phalcon\Helper\Arr;
use Psr\SimpleCache\CacheInterface;

use function is_array;
use function is_object;

/**
 * Creates a new Cache class
 *
 * @property AdapterFactory $adapterFactory
 */
class CacheFactory
{
    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;

    /**
     * CacheFactory constructor.
     *
     * @param AdapterFactory $factory
     */
    public function __construct(AdapterFactory $factory)
    {
        $this->adapterFactory = $factory;
    }

    /**
     * Factory to create an instance from a Config object
     *
     * @param array|Config $config = [
     *                             'adapter' => 'apcu',
     *                             'options' => [
     *                             'servers' => [
     *                             [
     *                             'host'   => 'localhost',
     *                             'port'   => 11211,
     *                             'weight' => 1,
     *
     *             ]
     *         ],
     *         'host'              => '127.0.0.1',
     *         'port'              => 6379,
     *         'index'             => 0,
     *         'persistent'        => false,
     *         'auth'              => '',
     *         'socket'            => '',
     *         'defaultSerializer' => 'Php',
     *         'lifetime'          => 3600,
     *         'prefix'            => 'phalcon',
     *         'storageDir'        => ''
     *     ]
     * ]
     *
     * @return CacheInterface
     * @throws Exception
     * @throws FactoryException
     */
    public function load($config)
    {
        if (is_object($config) && $config instanceof Config) {
            $config = $config->toArray();
        }

        if (!is_array($config)) {
            throw new Exception(
                "Config must be array or Phalcon\\Config object"
            );
        }

        if (!isset($config["adapter"])) {
            throw new Exception(
                "You must provide 'adapter' option in factory config parameter."
            );
        }

        $name    = (string) $config["adapter"];
        $options = Arr::get($config, "options", []);

        return $this->newInstance($name, $options);
    }

    /**
     * Constructs a new Cache instance.
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
     * @return CacheInterface
     * @throws FactoryException
     */
    public function newInstance(string $name, array $options = []): CacheInterface
    {
        $adapter = $this->adapterFactory->newInstance($name, $options);

        return new Cache($adapter);
    }
}

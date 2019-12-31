<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AuraPHP
 *
 * @link    https://github.com/auraphp/Aura.Di
 * @license https://github.com/auraphp/Aura.Di/blob/4.x/LICENSE
 */

declare(strict_types=1);

namespace Phalcon\Container\Config;

use InvalidArgumentException;
use Phalcon\Container\Config;
use Phalcon\Container\Container;

/**
 * A collection of Container config instructions
 *
 * @property array $configs
 */
class Collection extends Config
{
    /**
     * Configs
     *
     * @var ConfigInterface[]
     */
    protected $configs = [];

    /**
     * __construct
     *
     * @param array $configs A list of ContainerConfig classes to
     * instantiate and invoke for configuring the Container.
     */
    public function __construct(array $configs)
    {
        foreach ($configs as $config) {
            $config = $this->getConfig($config);
            $this->configs[] = $config;
        }
    }


    /**
     * Get config object from config class or return the object
     *
     * @param mixed $config name of class to instantiate
     *
     * @return ConfigInterface
     * @throws InvalidArgumentException if invalid config
     */
    protected function getConfig($config): ConfigInterface
    {
        if (is_string($config)) {
            $config = new $config();
        }

        if (!$config instanceof ConfigInterface) {
            throw new InvalidArgumentException(
                'Container configs must implement ConfigInterface'
            );
        }

        return $config;
    }

    /**
     * Define params, setters, and services for each of the configs before the
     * Container is locked.
     *
     * @param Container $container The DI container.
     */
    public function define(Container $container): void
    {
        foreach ($this->configs as $config) {
            $config->define($container);
        }
    }

    /**
     * Modify service objects for each config after the Container is locked.
     *
     * @param Container $container The DI container.
     */
    public function modify(Container $container): void
    {
        foreach ($this->configs as $config) {
            $config->modify($container);
        }
    }
}

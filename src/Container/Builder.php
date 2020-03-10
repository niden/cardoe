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

namespace Phalcon\Container;

use Phalcon\Container;
use Phalcon\Container\Config\Collection;
use Phalcon\Container\Exception\SetterMethodNotFound;
use Phalcon\Container\Injection\InjectionFactory;
use Phalcon\Container\Resolver\AutoResolver;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;

/**
 * Class Builder
 */
class Builder
{
    /**
     * Use the auto-resolver.
     *
     * @const true
     */
    public const AUTO_RESOLVE = true;

    /**
     * Returns a new Container instance.
     *
     * @param bool $autoResolve Use the auto-resolver?
     *
     * @return Container
     */
    public function newInstance(bool $autoResolve = false): Container
    {
        $resolver = $this->newResolver($autoResolve);
        return new Container(new InjectionFactory($resolver));
    }

    /**
     * Returns a new Resolver instance.
     *
     * @param bool $autoResolve Use the auto-resolver?
     *
     * @return Resolver
     */
    protected function newResolver(bool $autoResolve = false): Resolver
    {
        if ($autoResolve) {
            return new AutoResolver(new Reflector());
        }

        return new Resolver(new Reflector());
    }

    /**
     * Creates a new Container, applies ContainerConfig classes to define()
     * services, locks the container, and applies the ContainerConfig instances
     * to modify() services.
     *
     * @param array $configClasses A list of ContainerConfig classes to
     *                             instantiate and invoke for configuring the
     *                             Container.
     * @param bool  $autoResolve   Use the auto-resolver?
     *
     * @return Container
     *
     * @throws SetterMethodNotFound
     *
     */
    public function newConfiguredInstance(
        array $configClasses = [],
        bool $autoResolve = false
    ): Container {
        $container  = $this->newInstance($autoResolve);
        $collection = $this->newConfigCollection($configClasses);

        $collection->define($container);
        $container->lock();
        $collection->modify($container);

        return $container;
    }

    /**
     * Creates a new ContainerConfig for a collection of
     * ContainerConfigInterface classes
     *
     * @param array $classes A list of ContainerConfig classes to instantiate
     *                       and invoke for configuring the Container.
     *
     * @return Collection
     */
    protected function newConfigCollection(array $classes = []): Collection
    {
        return new Collection($classes);
    }
}

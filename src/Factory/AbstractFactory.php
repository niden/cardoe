<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Factory;

/**
 * Class AbstractFactory
 *
 * @package Cardoe\Factory
 */
abstract class AbstractFactory
{
    /**
     * @var array
     */
    protected $mapper = [];

    /**
     * @var array
     */
    protected $services = [];

    /**
     * Checks if a service exists and throws an exception
     *
     * @param string $name
     *
     * @throws Exception
     */
    protected function checkService(string $name): void
    {
        if (true !== isset($this->mapper[$name])) {
            throw new Exception("Service " . $name . " is not registered");
        }
    }

    /**
     * Returns the adapters for the factory
     */
    abstract protected function getAdapters(): array;

    /**
     * AdapterFactory constructor.
     *
     * @param array $services
     */
    protected function init(array $services = []): void
    {
        $adapters = $this->getAdapters();
        $adapters = array_merge($adapters, $services);

        foreach ($adapters as $name => $service) {
            $this->mapper[$name] = $service;
            unset($this->services[$name]);
        }
    }
}

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

namespace Phalcon\Factory;

use function array_merge;

/**
 * Class AbstractFactory
 *
 * @property array $mapper
 */
abstract class AbstractFactory
{
    /**
     * @var array
     */
    protected $mapper = [];

    /**
     * Checks if a service exists and throws an exception
     *
     * @param string $name
     *
     * @throws Exception
     */
    protected function checkService(string $name): void
    {
        if (!isset($this->mapper[$name])) {
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
        }
    }
}

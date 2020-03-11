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

namespace Phalcon\Container\Injection;

use Psr\Container\ContainerInterface;

/**
 * Returns a Container service when invoked.
 *
 * @property ContainerInterface $container
 * @property string             $service
 */
class LazyGet implements LazyInterface
{
    /**
     * The service container.
     *
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * The service name to retrieve.
     *
     * @var string
     */
    protected string $service;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container The service container.
     * @param string             $service   The service to retrieve.
     */
    public function __construct(ContainerInterface $container, string $service)
    {
        $this->container = $container;
        $this->service   = $service;
    }

    /**
     * Invokes the closure to create the instance.
     *
     * @return object The object created by the closure.
     */
    public function __invoke(): object
    {
        return $this->container->get($this->service);
    }
}

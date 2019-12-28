<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container;

use Phalcon\Container\Exception\ContainerException;
use Psr\Container\ContainerInterface;

/**
 * Class AbstractContainerAware
 *
 * @property ContainerInterface $container
 */
abstract class AbstractContainerAware implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Returns the container
     *
     * @return ContainerInterface
     * @throws ContainerException
     */
    public function getContainer(): ContainerInterface
    {
        if ($this->container instanceof ContainerInterface) {
            return $this->container;
        }

        throw new ContainerException('Container has not been set');
    }

    /**
     * Sets the container
     *
     * @param ContainerInterface $container
     *
     * @return ContainerAwareInterface
     */
    public function setContainer(ContainerInterface $container): ContainerAwareInterface
    {
        $this->container = $container;

        return $this;
    }
}

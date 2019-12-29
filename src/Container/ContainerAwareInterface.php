<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container;

use Psr\Container\ContainerInterface;

interface ContainerAwareInterface
{
    /**
     * Returns the container
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface;

    /**
     * Sets the container
     *
     * @param ContainerInterface $container
     *
     * @return ContainerAwareInterface
     */
    public function setContainer(ContainerInterface $container): ContainerAwareInterface;
}

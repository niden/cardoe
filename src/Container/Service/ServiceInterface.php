<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Service;

use Phalcon\Container\ContainerAwareInterface;

interface ServiceInterface extends ContainerAwareInterface
{
    /**
     * Adds an argument to the definition
     *
     * @param mixed $argument
     *
     * @return ServiceInterface
     */
    public function addArgument($argument): ServiceInterface;

    /**
     * Adds arguments based on the passed array
     *
     * @param array $arguments
     *
     * @return ServiceInterface
     */
    public function addArguments(array $arguments): ServiceInterface;

    /**
     * Adds a method to the definition
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return ServiceInterface
     */
    public function addMethod(string $method, array $arguments = []): ServiceInterface;

    /**
     * Adds methods based on the passed array [name => arguments]
     *
     * @param array $methods
     *
     * @return ServiceInterface
     */
    public function addMethods(array $methods = []): ServiceInterface;

    /**
     * Returns the compiled definition
     *
     * @return mixed
     */
    public function getCompiled();

    /**
     * Returns the name of the definition
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns if this definition is shared or not
     *
     * @return bool
     */
    public function isShared(): bool;

    /**
     * Resolves the definition
     *
     * @param bool $isFresh
     *
     * @return mixed
     */
    public function resolveService(bool $isFresh = false);

    /**
     * Sets the compiled definition
     *
     * @param $compiled
     *
     * @return ServiceInterface
     */
    public function setCompiled($compiled): ServiceInterface;

    /**
     * Sets the name of this definition
     *
     * @param string $name
     *
     * @return ServiceInterface
     */
    public function setName(string $name): ServiceInterface;

    /**
     * Sets this definition shared or not
     *
     * @param bool $shared
     *
     * @return ServiceInterface
     */
    public function setShared(bool $shared): ServiceInterface;
}

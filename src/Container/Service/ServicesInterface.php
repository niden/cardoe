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

/**
 * Interface ServicesInterface
 */
interface ServicesInterface extends ContainerAwareInterface
{
    /**
     * Adds a definition
     *
     * @param string $name
     * @param mixed  $definition
     * @param bool   $shared
     *
     * @return ServiceInterface
     */
    public function add(string $name, $definition, bool $shared = false): ServiceInterface;

    /**
     * Returns a definition based on its name
     *
     * @param string $name
     *
     * @return ServiceInterface
     */
    public function get(string $name): ServiceInterface;

    /**
     * Checks if a definition exists in the internal collection
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Resolves a definition
     *
     * @param string $name
     * @param bool   $isFresh
     *
     * @return mixed
     */
    public function resolve(string $name, bool $isFresh = false);

    /**
     * Returns the internal array
     */
    public function toArray(): array;
}

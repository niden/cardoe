<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Argument;

use Phalcon\Container\ContainerAwareInterface;
use ReflectionFunctionAbstract;

interface ResolverInterface extends ContainerAwareInterface
{
    /**
     * Reflects on the method and passed arguments
     *
     * @param ReflectionFunctionAbstract $method
     * @param array                      $arguments
     *
     * @return array
     */
    public function reflectArguments(ReflectionFunctionAbstract $method, array $arguments = []): array;

    /**
     * Resolves the arguments
     *
     * @param array $arguments
     *
     * @return array
     */
    public function resolveArguments(array $arguments): array;
}

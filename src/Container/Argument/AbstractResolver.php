<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Argument;

use Phalcon\Container\AbstractContainerAware;
use Phalcon\Container\Exception\NotFoundException;
use ReflectionException;
use ReflectionFunctionAbstract;
use ReflectionParameter;

abstract class AbstractResolver extends AbstractContainerAware
{
    /**
     * Reflects on the method and passed arguments
     *
     * @param ReflectionFunctionAbstract $method
     * @param array                      $arguments
     *
     * @return array
     * @throws ReflectionException
     */
    public function reflectArguments(ReflectionFunctionAbstract $method, array $arguments = []): array
    {
        $resolved   = [];
        $parameters = $method->getParameters();

        /** @var ReflectionParameter $parameter */
        foreach ($parameters as $index => $parameter) {
            $name  = $parameter->getName();
            $class = $parameter->getClass();

            if (array_key_exists($name, $arguments)) {
                $resolved[$index] = $arguments[$name];
                continue;
            }

            if (null !== $class) {
                $resolved[$index] = $class->getName();
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $resolved[$index] = $parameter->getDefaultValue();
                continue;
            }

            throw new NotFoundException(
                sprintf(
                    "Cannot resolve parameter [%s] for [%s]",
                    $parameter->getName(),
                    $method->getName()
                )
            );
        }

        return $this->resolveArguments($resolved);
    }

    /**
     * Resolves the arguments
     *
     * @param array $arguments
     *
     * @return array
     */
    public function resolveArguments(array $arguments): array
    {
        $resolved = [];
        foreach ($arguments as $argument) {
            if ($argument instanceof RawInterface) {
                $resolved[] = $argument->get();
                continue;
            }

            if ($argument instanceof ClassNameInterface) {
                $argument = $argument->get();
            }

            if (!is_string($argument)) {
                continue;
            }

            $container = $this->getContainer();

            if ($container->has($argument)) {
                $argument = $container->get($argument);


                if ($argument instanceof RawInterface) {
                    $argument = $argument->get();
                }
            }

            $resolved[] = $argument;
        }

        return $resolved;
    }
}

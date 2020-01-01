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

use Exception as BaseException;
use Phalcon\Container\Exception\ContainerLocked;
use Phalcon\Container\Exception\MissingParameter;
use Phalcon\Container\Exception\MutationDoesNotImplementInterface;
use Phalcon\Container\Exception\NoSuchProperty;
use Phalcon\Container\Exception\ServiceNotFound;
use Phalcon\Container\Exception\ServiceNotObject;
use Phalcon\Container\Exception\SetterMethodNotFound;
use Psr\Container\ContainerExceptionInterface;

use function gettype;
use function is_object;

/**
 * Class Exception
 *
 * @package Phalcon\Container
 */
class Exception extends BaseException implements ContainerExceptionInterface
{
    /**
     * The container is locked and cannot be modified.
     *
     * @return ContainerLocked
     * @throws ContainerLocked
     */
    public static function containerLocked(): ContainerLocked
    {
        throw new ContainerLocked(
            "Cannot modify container when locked."
        );
    }

    /**
     * A class constructor param was not defined.
     *
     * @param string $class The class name.
     * @param string $parameter The constructor param name.
     *
     * @return MissingParameter
     */
    public static function missingParameter(
        string $class,
        string $parameter
    ): MissingParameter {
        throw new MissingParameter(
            "Parameter missing: " . $class . "::\$" . $parameter
        );
    }

    /**
     * The container does not have a requested service.
     *
     * @param string $service The service name.
     *
     * @return ServiceNotFound
     */
    public static function serviceNotFound(string $service): ServiceNotFound
    {
        throw new ServiceNotFound(
            "Service not defined: '" . $service . "'"
        );
    }

    /**
     * A setter method was defined, but it not available on the class.
     *
     * @param string $class  The class name.
     * @param string $method The method name.
     *
     * @return SetterMethodNotFound
     */
    public static function setterMethodNotFound(
        string $class,
        string $method
    ): SetterMethodNotFound {
        throw new SetterMethodNotFound(
            "Setter method not found: " . $class . "::" . $method . "()"
        );
    }

    /**
     * A mutation was lazy and returned a value that is not an instanceof
     * MutationInterface.
     *
     * @param mixed $value The returned value.
     *
     * @return MutationDoesNotImplementInterface>
     */
    public static function mutationDoesNotImplementInterface($value): MutationDoesNotImplementInterface
    {
        if (is_object($value)) {
            $className = get_class($value);
            throw new MutationDoesNotImplementInterface(
                "Mutation does not implement interface: " . $className
            );
        }

        $typeName = gettype($value);
        throw new MutationDoesNotImplementInterface(
            "Expected Mutation interface, got: " . $typeName
        );
    }

    /**
     * A requested property does not exist.
     *
     * @param string $name The property name.
     *
     * @return NoSuchProperty
     * @throws NoSuchProperty
     */
    public static function noSuchProperty(string $name): NoSuchProperty
    {
        throw new NoSuchProperty("Property does not exist: \$" . $name);
    }
}

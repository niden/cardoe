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

use Phalcon\Container\Exception\ContainerLocked;
use Phalcon\Container\Exception\MissingParameter;
use Phalcon\Container\Exception\MutationDoesNotImplementInterface;
use Phalcon\Container\Exception\NoSuchProperty;
use Phalcon\Container\Exception\ServiceNotFound;
use Phalcon\Container\Exception\ServiceNotObject;
use Phalcon\Container\Exception\SetterMethodNotFound;
use Psr\Container\ContainerExceptionInterface;
use Throwable;

use function gettype;
use function is_object;

class Exception extends \Exception implements ContainerExceptionInterface, Throwable
{
    /**
     * A mutation was lazy and returned a value that is not an instanceof
     * MutationInterface.
     *
     * @param mixed $value The returned value.
     *
     * @return SetterMethodNotFound
     * @throws MutationDoesNotImplementInterface
     */
    public static function mutationDoesNotImplementInterface($value): SetterMethodNotFound
    {
        if (is_object($value)) {
            $className = get_class($value);
            throw new MutationDoesNotImplementInterface(
                "Mutation does not implement interface: {$className}"
            );
        }

        $typeName = gettype($value);
        throw new MutationDoesNotImplementInterface(
            "Expected Mutation interface, got: {$typeName}"
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
        throw new NoSuchProperty("Property does not exist: \${$name}");
    }
}


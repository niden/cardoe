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

namespace Phalcon\Test\Fixtures\Container;

use Codeception\Stub;
use ReflectionClass;
use ReflectionFunctionAbstract;
use ReflectionParameter;

class ArgumentResolverReflectArgumentsMethod extends ReflectionFunctionAbstract
{
    public function getParameters()
    {
        return [
            Stub::make(
                ReflectionParameter::class,
                [
                    "getName"  => "parameterOne",
                    "getClass" => Stub::make(
                        ReflectionClass::class,
                        [
                            "getName" => "ClassOne",
                        ]
                    ),
                ]
            ),
            Stub::make(
                ReflectionParameter::class,
                [
                    "getName"                 => "parameterTwo",
                    "getClass"                => null,
                    "isDefaultValueAvailable" => true,
                    "getDefaultValue"         => "twoDefault",
                ]
            ),
            Stub::make(
                ReflectionParameter::class,
                [
                    "getName"  => "parameterThree",
                    "getClass" => null,
                ]
            ),
        ];
    }

    /**
     * @inheritDoc
     */
    public static function export()
    {
        return "";
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return "";
    }
}
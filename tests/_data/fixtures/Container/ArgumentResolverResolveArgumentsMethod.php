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
use ReflectionFunctionAbstract;

class ArgumentResolverResolveArgumentsMethod extends ReflectionFunctionAbstract
{
    public function getParameters()
    {
        return [
            Stub::make(
                \ReflectionParameter::class,
                [
                    "getName"                 => "one",
                    "getClass"                => null,
                    "isDefaultValueAvailable" => false,
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
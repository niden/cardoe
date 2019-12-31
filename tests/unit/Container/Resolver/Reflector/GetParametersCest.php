<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Reflector;

use Phalcon\Container\Resolver\Reflector;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use ReflectionParameter;
use UnitTester;

class GetParametersCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Reflector :: getParameters()
     *
     * @since  2019-12-30
     */
    public function containerResolverReflectorGetParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Reflector - getParameters()');

        $reflector = new Reflector();
        $return    = $reflector->getParameters(ParentFixtureClass::class);
        $I->assertIsArray($return);
        $I->assertInstanceOf(ReflectionParameter::class, $return[0]);
    }
}

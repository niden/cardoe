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
use ReflectionClass;
use UnitTester;

class GetClassCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Reflector :: getClass()
     *
     * @since  2019-12-30
     */
    public function containerResolverReflectorGetClass(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Reflector - getClass()');

        $reflector = new Reflector();
        $return    = $reflector->getClass(ParentFixtureClass::class);
        $I->assertInstanceOf(ReflectionClass::class, $return);
        $I->assertEquals(ParentFixtureClass::class, $return->getName());
    }
}

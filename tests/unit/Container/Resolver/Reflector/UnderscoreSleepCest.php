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
use Phalcon\Test\Fixtures\Container\WithTraitClass;
use ReflectionClass;
use ReflectionParameter;
use UnitTester;

class UnderscoreSleepCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Reflector :: __sleep()
     *
     * @since  2019-12-30
     */
    public function containerResolverReflectorUnderscoreSleep(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Reflector - __sleep()');

        $reflector = new Reflector();
        $return    = $reflector->getClass(ParentFixtureClass::class);
        $I->assertInstanceOf(ReflectionClass::class, $return);
        $I->assertEquals(ParentFixtureClass::class, $return->getName());

        $return = $reflector->getParameters(ParentFixtureClass::class);
        $I->assertIsArray($return);
        $I->assertInstanceOf(ReflectionParameter::class, $return[0]);

        $return = $reflector->getTraits(WithTraitClass::class);
        $I->assertIsArray($return);
        $I->assertCount(3, $return);

        $serialized = serialize($reflector);
        $I->assertTrue(is_string($serialized));

        /** @var Reflector $reflector */
        $reflector = unserialize($serialized);
        $I->assertInstanceOf(Reflector::class, $reflector);
    }
}

<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\Factory;

use Phalcon\Container\Injection\Factory;
use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use UnitTester;

class WithContextCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\Factory :: withContext()
     *
     * @since  2019-12-30
     */
    public function containerInjectionFactoryWithContext(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\Factory - withContext()');

        $factory = new Factory(
            new Resolver(new Reflector()),
            new Blueprint(OtherFixtureClass::class)
        );

        $other = $factory->withContext(new Blueprint(OtherFixtureClass::class));

        $I->assertNotEquals($factory, $other);
        $I->assertInstanceOf(Factory::class, $factory);
        $I->assertInstanceOf(Factory::class, $other);
    }
}

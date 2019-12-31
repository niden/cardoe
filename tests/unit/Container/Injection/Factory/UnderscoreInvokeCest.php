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
use Phalcon\Container\Injection\InjectionFactory;
use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Test\Fixtures\Container\ChildFixtureClass;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\Factory :: __invoke()
     *
     * @since  2019-12-30
     */
    public function containerInjectionFactoryUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\Factory - __invoke()');

        $factory = new InjectionFactory(new Resolver(new Reflector()));
        $other   = $factory->newInstance(new Blueprint(OtherFixtureClass::class));

        $factory = new Factory(
            new Resolver(new Reflector()),
            new Blueprint(
                ChildFixtureClass::class,
                [
                    'name'  => 'tuvok',
                    'other' => $other,
                ],
                [
                    'setData' => 'neelix',
                ]
            )
        );

        $actual = $factory();

        $I->assertInstanceOf(ChildFixtureClass::class, $actual);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual->getOther());
        $I->assertEquals('tuvok', $actual->getName());
        $I->assertEquals('neelix', $actual->getData());
    }
}

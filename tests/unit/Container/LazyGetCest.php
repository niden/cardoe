<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use Phalcon\Container;
use Phalcon\Container\Builder;
use Phalcon\Container\Injection\InjectionFactory;
use Phalcon\Container\Injection\LazyGet;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Test\Fixtures\Container\ContainerFixture;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use stdClass;
use UnitTester;

class LazyGetCest
{
    /**
     * Unit Tests Phalcon\Container :: lazyGet()
     *
     * @since  2020-01-01
     */
    public function containerLazyGet(UnitTester $I)
    {
        $I->wantToTest('Container - lazyGet()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container->set(
            'other',
            function () {
                return new OtherFixtureClass();
            }
        );

        $lazy = $container->lazyGet('other');
        $I->assertInstanceOf(LazyGet::class, $lazy);

        $actual = $lazy();
        $I->assertInstanceOf(OtherFixtureClass::class, $actual);
    }

    /**
     * Unit Tests Phalcon\Container :: lazyGet() - delegate
     *
     * @since  2020-01-01
     */
    public function containerLazyGetDelegate(UnitTester $I)
    {
        $I->wantToTest('Container - lazyGet() - delegate');

        $delegate = new ContainerFixture(
            [
                "person" => function () {
                    $obj = new stdClass();
                    $obj->name = "seven";

                    return $obj;
                }
            ]
        );
        $container = new Container(
            new InjectionFactory(new Resolver(new Reflector())),
            $delegate
        );

        $lazy = $container->lazyGet('person');
        $I->assertInstanceOf(LazyGet::class, $lazy);

        $person = $lazy();
        $I->assertInstanceOf(stdClass::class, $person);
        $I->assertEquals('seven', $person->name);
    }
}

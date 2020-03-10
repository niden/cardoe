<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use Phalcon\Container\Builder;
use Phalcon\Container\Injection\LazyNew;
use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Test\Fixtures\Container\ContextChildClass;
use Phalcon\Test\Fixtures\Container\ContextGrandChildClass;
use Phalcon\Test\Fixtures\Container\ContextParentClass;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use Phalcon\Test\Fixtures\Container\VariadicFixtureClass;
use UnitTester;

class LazyNewCest
{
    /**
     * Unit Tests Phalcon\Container :: lazyNew()
     *
     * @since  2020-01-01
     */
    public function containerLazyNew(UnitTester $I)
    {
        $I->wantToTest('Container - lazyNew()');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazy = $container->lazyNew(OtherFixtureClass::class);
        $I->assertInstanceOf(LazyNew::class, $lazy);

        $actual = $lazy();
        $I->assertInstanceOf(OtherFixtureClass::class, $actual);
    }

    /**
     * Unit Tests Phalcon\Container :: lazyNew() - variadic
     *
     * @since  2020-01-01
     */
    public function containerLazyNewVariadic(UnitTester $I)
    {
        $I->wantToTest('Container - lazyNew() - variadic');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $name  = 'seven';
        $items = [
            (object) ['id' => 1],
            (object) ['id' => 2],
        ];

        $lazy = $container->lazyNew(
            VariadicFixtureClass::class,
            [
                'name'  => $name,
                'items' => $items,
            ]
        );

        $I->assertInstanceOf(LazyNew::class, $lazy);

        $instance = $lazy();
        $I->assertEquals($name, $instance->getName());
        $I->assertEquals($items, $instance->getItems());
    }

    /**
     * Unit Tests Phalcon\Container :: lazyNew() - contextual parameters
     *
     * @since  2020-01-01
     */
    public function containerLazyNewContextualParameters(UnitTester $I)
    {
        $I->wantToTest('Container - lazyNew() - contextual parameters');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $container
            ->parameters()
            ->set(
                ContextParentClass::class,
                [
                    'store' => $container->lazyNew(ContextChildClass::class),
                ]
            )
            ->set(
                ContextChildClass::class,
                [
                    'store' => $container->lazyNew(ContextGrandChildClass::class),
                ]
            )
            ->set(
                ContextGrandChildClass::class,
                [
                    'store' => 'voyager',
                ]
            )
        ;

        $lazy   = $container->lazyNew(ContextGrandChildClass::class);
        $actual = $lazy();

        $I->assertEquals('voyager', $actual->store);

        $lazy = $container
            ->lazyNew(ContextParentClass::class)
            ->withContext(
                new Blueprint(
                    ContextGrandChildClass::class,
                    [
                        'store' => 'enterprise',
                    ]
                )
            )
        ;

        $actual = $lazy();
        $I->assertEquals('enterprise', $actual->store->store->store);

        $lazy   = $container->lazyNew(ContextGrandChildClass::class);
        $actual = $lazy();

        $I->assertEquals('voyager', $actual->store);
    }
}

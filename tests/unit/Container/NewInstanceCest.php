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
use Phalcon\Test\Fixtures\Container\ChildFixtureClass;
use Phalcon\Test\Fixtures\Container\InterfaceFixtureClass;
use Phalcon\Test\Fixtures\Container\MutationFixtureClass;
use Phalcon\Test\Fixtures\Container\MutationWithDependencyFixtureClass;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use Phalcon\Test\Fixtures\Container\VariadicFixtureClass;
use UnitTester;

class NewInstanceCest
{
    /**
     * Unit Tests Phalcon\Container :: newInstance() - defaults
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceDefaults(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - defaults');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $instance = $container->newInstance(ParentFixtureClass::class);
        $expected = 'seven';
        $actual   = $instance->getStore();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - overrides
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceOverrides(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - overrides');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $instance = $container->newInstance(
            ParentFixtureClass::class,
            [
                'store' => 'tuvok',
            ]
        );
        $expected = 'tuvok';
        $actual   = $instance->getStore();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - variadic
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceVariadic(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - variadic');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $name  = 'seven';
        $items = [
            (object) ['id' => 1],
            (object) ['id' => 2],
        ];

        $instance = $container->newInstance(
            VariadicFixtureClass::class,
            [
                'name'  => $name,
                'items' => $items,
            ]
        );
        $I->assertEquals($name, $instance->getName());
        $I->assertEquals($items, $instance->getItems());
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - lazy parameters
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceLazyParameters(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - lazy parameters');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazy = $container->lazy(
            function () {
                return new OtherFixtureClass();
            }
        );

        $class = ParentFixtureClass::class;
        $actual = $container->newInstance(
            $class,
            [
                'store' => $lazy,
            ]
        );
        $I->assertInstanceOf($class, $actual);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual->getStore());
    }

//    /**
//     * Unit Tests Phalcon\Container :: newInstance() - setter
//     *
//     * @since  2020-01-01
//     */
//    public function containerNewInstanceSetter(UnitTester $I)
//    {
//        $I->wantToTest('Container - newInstance() - setter');
//
//        $builder   = new Builder();
//        $container = $builder->newInstance();
//        $container
//            ->setters()
//            ->set('setData', 'voyager')
//        ;
//        $actual = $container->newInstance(
//            ChildFixtureClass::class,
//            [
//                'store' => 'seven',
//                'other' => new OtherFixtureClass(),
//            ]
//        );
//        $I->assertEquals('seven', $actual->getStore());
//        $I->assertEquals('voyager', $actual->getData());
//        $I->assertInstanceOf(OtherFixtureClass::class, $actual->getOther());
//    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - mutation
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceMutation(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - mutation');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->mutations()
            ->set(
                InterfaceFixtureClass::class,
                [
                    new MutationFixtureClass('enterprise'),
                ]
            )
        ;

        $actual = $container->newInstance(InterfaceFixtureClass::class);
        $I->assertEquals('enterprise', $actual->getShip());
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - mutation lazy
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceMutationLazy(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - mutation lazy');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->mutations()
            ->set(
                InterfaceFixtureClass::class,
                [
                    new MutationFixtureClass('enterprise'),
                ]
            )
        ;

        $actual = $container->newInstance(InterfaceFixtureClass::class);
        $I->assertEquals('enterprise', $actual->getShip());
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - with lazy mutation injection container
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceMutationLazyInjectionContainer(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - with lazy mutation injection container');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->parameters()
            ->set(
                MutationWithDependencyFixtureClass::class,
                [
                    'container' => $container,
                ]
            )
        ;
        $container
            ->mutations()
            ->set(
                InterfaceFixtureClass::class,
                [
                    $container->lazyNew(
                        MutationWithDependencyFixtureClass::class
                    )
                ]
            )
        ;
        $container->set(
            'service',
            $container->lazyNew(OtherFixtureClass::class)
        );

        $actual = $container->newInstance(InterfaceFixtureClass::class);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual->getShip());
    }
}

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
use Phalcon\Container\Exception\MissingParameter;
use Phalcon\Container\Exception\SetterMethodNotFound;
use Phalcon\Test\Fixtures\Container\ChildFixtureClass;
use Phalcon\Test\Fixtures\Container\InterfaceChildFixtureClassClass;
use Phalcon\Test\Fixtures\Container\InterfaceFixture;
use Phalcon\Test\Fixtures\Container\InterfaceFixtureClass;
use Phalcon\Test\Fixtures\Container\InterfaceGrandChildFixtureClass;
use Phalcon\Test\Fixtures\Container\InterfaceParentFixtureClass;
use Phalcon\Test\Fixtures\Container\MutationFixtureClass;
use Phalcon\Test\Fixtures\Container\MutationWithDependencyFixtureClass;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use Phalcon\Test\Fixtures\Container\ResolveFixtureClass;
use Phalcon\Test\Fixtures\Container\VariadicFixtureClass;
use Phalcon\Test\Fixtures\Container\WithDefaultParamChildClass;
use Phalcon\Test\Fixtures\Container\WithDefaultParamParentClass;
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
     * Unit Tests Phalcon\Container :: newInstance() - defaults for child class
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceDefaultsForChildClass(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - defaults for child class');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $actual = $container->newInstance(WithDefaultParamParentClass::class);
        $I->assertEquals(1, $actual->first);
        $I->assertEquals(2, $actual->second);

        $actual = $container->newInstance(WithDefaultParamChildClass::class);
        $I->assertEquals(1, $actual->first);
        $I->assertEquals(3, $actual->second);
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

    /**
     * Unit Tests Phalcon\Container :: newInstance() - setter interfaces overrides
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceSetterInterfacesOverrides(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - setter interfaces overrides');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->setters()
            ->set(
                InterfaceFixture::class,
                [
                    'setShip' => 'voyager',
                ]
            )
            ->set(
                InterfaceChildFixtureClassClass::class,
                [
                    'setShip' => 'enterprise',
                ]
            )
        ;
        
        // "inherits" initial value from interface
        $actual = $container->newInstance(InterfaceFixtureClass::class);
        $I->assertSame('voyager', $actual->getShip());

        // uses initial value "inherited" from parent
        $actual = $container->newInstance(InterfaceParentFixtureClass::class);
        $I->assertSame('voyager', $actual->getShip());

        // overrides the initial "inherited" value
        $actual = $container->newInstance(InterfaceChildFixtureClassClass::class);
        $I->assertSame('enterprise', $actual->getShip());

        // uses the "inherited" overridde value
        $actual = $container->newInstance(InterfaceGrandChildFixtureClass::class);
        $I->assertSame('enterprise', $actual->getShip());
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - setter
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceSetter(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - setter');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->setters()
            ->set(
                ChildFixtureClass::class,
                [
                    'setData' => 'voyager',
                ]
            )
        ;

        $actual = $container->newInstance(
            ChildFixtureClass::class,
            [
                'store' => 'enterprise',
                'other' => new OtherFixtureClass(),
            ]
        );

        $I->assertEquals('voyager', $actual->getData());
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - lazy setter
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceLazySetter(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - lazy setter');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazy = $container->lazy(
            function () {
                return new OtherFixtureClass();
            }
        );

        $container
            ->setters()
            ->set(
                ChildFixtureClass::class,
                [
                    'setData' => $lazy,
                ]
            )
        ;

        $actual = $container->newInstance(
            ChildFixtureClass::class,
            [
                'store' => 'enterprise',
                'other' => new OtherFixtureClass(),
            ]
        );

        $I->assertInstanceOf(OtherFixtureClass::class, $actual->getData());
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - setter exception
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceSetterException(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - setter exception');

        $I->expectThrowable(
            new SetterMethodNotFound(
                'Setter method not found: Phalcon\Test\Fixtures\Container\OtherFixtureClass::setUnknown()'
            ),
            function () {
                $builder   = new Builder();
                $container = $builder->newInstance();

                $container
                    ->setters()
                    ->set(
                        OtherFixtureClass::class,
                        [
                            'setUnknown' => 'unknown',
                        ]
                    )
                ;

                $container->newInstance(OtherFixtureClass::class);
            }
        );
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - parameters positional
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceParametersPositional(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - parameters positional');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $other  = $container->newInstance(OtherFixtureClass::class);
        $actual = $container->newInstance(
            ChildFixtureClass::class,
            [
                'voyager',
                $other,
            ]
        );

        $I->assertInstanceOf(ChildFixtureClass::class, $actual);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual->getOther());
        $I->assertEquals('voyager', $actual->getStore());

        // positional overrides names
        $actual = $container->newInstance(
            ChildFixtureClass::class,
            [
                0       => 'enterprise',
                'store' => 'voyager',
                $other,
            ]
        );

        $I->assertInstanceOf(ChildFixtureClass::class, $actual);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual->getOther());
        $I->assertEquals('enterprise', $actual->getStore());
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - parameter exception
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceParameterException(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - parameter exception');

        $I->expectThrowable(
            new MissingParameter(
                'Parameter missing: Phalcon\Test\Fixtures\Container\ResolveFixtureClass::$class'
            ),
            function () {
                $builder   = new Builder();
                $container = $builder->newInstance();

                $container->newInstance(ResolveFixtureClass::class);
            }
        );
    }

    /**
     * Unit Tests Phalcon\Container :: newInstance() - without missing parameter
     *
     * @since  2020-01-01
     */
    public function containerNewInstanceWithoutMissingParameter(UnitTester $I)
    {
        $I->wantToTest('Container - newInstance() - without missing parameter');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->parameters()
            ->set(
                ResolveFixtureClass::class,
                [
                    'class' => $container->lazyNew(ParentFixtureClass::class),
                ]
            );

        $actual = $container->newInstance(ResolveFixtureClass::class);
        $I->assertInstanceOf(ResolveFixtureClass::class, $actual);
        $I->assertInstanceOf(ParentFixtureClass::class, $actual->class);
    }
}

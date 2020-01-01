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
use Phalcon\Container\Resolver\ValueObject;
use Phalcon\Test\Fixtures\Container\ParametersFixtureClass;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use Phalcon\Test\Fixtures\Container\ResolveFixtureClass;
use UnitTester;

class SerializeUnserializeCest
{
    /**
     * Unit Tests Phalcon\Container :: serialize()/unserialize()
     *
     * @since  2020-01-01
     */
    public function containerSerializeUnserialize(UnitTester $I)
    {
        $I->wantToTest('Container - serialize()/unserialize()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->parameters()
            ->set(
                ParametersFixtureClass::class,
                [
                    'data'  => [],
                    'empty' => 'abc'
                ]
            )
        ;

        $instance = $container->newInstance(ParametersFixtureClass::class);
        $I->assertInstanceOf(ParametersFixtureClass::class, $instance);

        $serialized = serialize($container);

        $unserialized = unserialize($serialized);

        $instance = $unserialized->newInstance(
            ParametersFixtureClass::class,
            [
                'data' => ['one' => 1]
            ]
        );
        $I->assertInstanceOf(ParametersFixtureClass::class, $instance);
        $I->assertEquals(['one' => 1], $instance->data);
    }

    /**
     * Unit Tests Phalcon\Container :: serialize()/unserialize() lazy
     *
     * @since  2020-01-01
     */
    public function containerSerializeUnserializeLazy(UnitTester $I)
    {
        $I->wantToTest('Container - serialize()/unserialize() lazy');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->parameters()
            ->set(
                ResolveFixtureClass::class,
                [
                    'class' => $container->lazyNew(ParentFixtureClass::class)
                ]
            )
        ;

        $instance = $container->newInstance(ResolveFixtureClass::class);

        $I->assertInstanceOf(ResolveFixtureClass::class, $instance);
        $I->assertInstanceOf(ParentFixtureClass::class, $instance->class);

        $serialized   = serialize($container);
        $unserialized = unserialize($serialized);

        $instance = $unserialized->newInstance(ResolveFixtureClass::class);

        $I->assertInstanceOf(ResolveFixtureClass::class, $instance);
        $I->assertInstanceOf(ParentFixtureClass::class, $instance->class);
    }

    /**
     * Unit Tests Phalcon\Container :: serialize()/unserialize() service
     *
     * @since  2020-01-01
     */
    public function containerSerializeUnserializeService(UnitTester $I)
    {
        $I->wantToTest('Container - serialize()/unserialize() service');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->parameters()
            ->set(
                ResolveFixtureClass::class,
                [
                    'class' => $container->lazyNew(ParentFixtureClass::class)
                ]
            )
        ;

        $container->set('resolveService', $container->lazyNew(ResolveFixtureClass::class));
        $instance = $container->get('resolveService');

        $I->assertInstanceOf(ResolveFixtureClass::class, $instance);
        $I->assertInstanceOf(ParentFixtureClass::class, $instance->class);

        $serialized   = serialize($container);
        $unserialized = unserialize($serialized);

        $instance = $unserialized->get('resolveService');

        $I->assertInstanceOf(ResolveFixtureClass::class, $instance);
        $I->assertInstanceOf(ParentFixtureClass::class, $instance->class);
    }

    /**
     * Unit Tests Phalcon\Container :: serialize()/unserialize() callable
     *
     * @since  2020-01-01
     */
    public function containerSerializeUnserializeCallable(UnitTester $I)
    {
        $I->wantToTest('Container - serialize()/unserialize() callable');

        $I->expectThrowable(
            new \Exception(
                "Serialization of 'Closure' is not allowed"
            ),
            function () {
                $builder   = new Builder();
                $container = $builder->newInstance();
                $container
                    ->parameters()
                    ->set(
                        ResolveFixtureClass::class,
                        [
                            'class' => $container->lazy(
                                function () {
                                    return new ParentFixtureClass();
                                }
                            ),
                        ]
                    )
                ;

                $container->newInstance(ResolveFixtureClass::class);
                serialize($container);
            }
        );
    }
}

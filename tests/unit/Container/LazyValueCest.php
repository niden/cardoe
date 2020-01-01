<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use InvalidArgumentException;
use Phalcon\Container\Builder;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use UnitTester;

class LazyValueCest
{
    /**
     * Unit Tests Phalcon\Container :: lazyValue()
     *
     * @since  2020-01-01
     */
    public function containerLazyValue(UnitTester $I)
    {
        $I->wantToTest('Container - lazyValue()');
        $builder   = new Builder();
        $container = $builder->newInstance();

        $container
            ->parameters()
            ->set(
                ParentFixtureClass::class,
                [
                    'name' => $container->lazyValue('name'),
                ]
            );
        $container
            ->values()
            ->set('name', 'neelix')
        ;

        $actual = $container->newInstance(ParentFixtureClass::class);
        $I->assertEquals('neelix', $actual->getName());
    }

    /**
     * Unit Tests Phalcon\Container :: lazyValue() - with lazy
     *
     * @since  2020-01-01
     */
    public function containerLazyValueWithLazy(UnitTester $I)
    {
        $I->wantToTest('Container - lazyValue() - with lazy');
        $builder   = new Builder();
        $container = $builder->newInstance();

        $container
            ->parameters()
            ->set(
                ParentFixtureClass::class,
                [
                    'name' => $container->lazyValue('name'),
                ]
            );
        $container
            ->values()
            ->set('name', $container->lazyValue('two'))
            ->set('two', 'doctor')
        ;

        $actual = $container->newInstance(ParentFixtureClass::class);
        $I->assertEquals('doctor', $actual->getName());
    }

    /**
     * Unit Tests Phalcon\Container :: lazyValue() - exception
     *
     * @since  2020-01-01
     */
    public function containerLazyValueException(UnitTester $I)
    {
        $I->wantToTest('Container - lazyValue() - exception');
        $I->expectThrowable(
            new InvalidArgumentException(
                'Unknown key (uknown) in container value'
            ),
            function () {
                $builder   = new Builder();
                $container = $builder->newInstance();

                $container
                    ->parameters()
                    ->set(
                        ParentFixtureClass::class,
                        [
                            'name' => $container->lazyValue('uknown'),
                        ]
                    )
                ;

                $container->newInstance(ParentFixtureClass::class);
            }
        );
    }
}

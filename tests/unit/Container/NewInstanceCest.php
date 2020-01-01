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
        $actual   = $instance->getName();
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
                'name' => 'tuvok',
            ]
        );
        $expected = 'tuvok';
        $actual   = $instance->getName();
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
}

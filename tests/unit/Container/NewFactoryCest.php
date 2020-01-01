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
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use UnitTester;

class NewFactoryCest
{
    /**
     * Unit Tests Phalcon\Container :: newFactory()
     *
     * @since  2020-01-01
     */
    public function containerNewFactory(UnitTester $I)
    {
        $I->wantToTest('Container - newFactory()');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $other = $container->newInstance(OtherFixtureClass::class);
        $factory = $container->newFactory(
            ChildFixtureClass::class,
            [
                'store' => 'doctor',
                'other' => $other,
            ],
            [
                'setData' => 'voyager',
            ]
        );

        $actual = $factory();

        $I->assertInstanceOf(ChildFixtureClass::class, $actual);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual->getOther());
        $I->assertEquals('doctor', $actual->getStore());
        $I->assertEquals('voyager', $actual->getData());

        $second = $factory();
        $I->assertNotSame($second, $actual);
    }
}

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
use Phalcon\Container\Exception\ServiceNotFound;
use Phalcon\Test\Fixtures\Container\NullChildConstructClass;
use Phalcon\Test\Fixtures\Container\NullParentConstructClass;
use UnitTester;

class GetSetHasCest
{
    /**
     * Unit Tests Phalcon\Container :: get() - exception
     *
     * @since  2020-01-01
     */
    public function containerGetException(UnitTester $I)
    {
        $I->wantToTest('Container - get() - exception');

        $I->expectThrowable(
            new ServiceNotFound(
                "Service not defined: 'unknown'"
            ),
            function () {
                $builder   = new Builder();
                $container = $builder->newInstance();
                $container->get('unknown');
            }
        );
    }

    /**
     * Unit Tests Phalcon\Container :: get()/set()/has()
     *
     * @since  2020-01-01
     */
    public function containerGetSetHas(UnitTester $I)
    {
        $I->wantToTest('Container - get()/set()/has()');

        $expect = (object) [];

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container->set('voyager', $expect);

        $I->assertTrue($container->has('voyager'));
        $I->assertFalse($container->has('borg'));

        $actual = $container->get('voyager');
        $I->assertEquals($expect, $actual);

        // get it again for coverage
        $actual = $container->get('voyager');
        $I->assertEquals($expect, $actual);
    }

    /**
     * Unit Tests Phalcon\Container :: get() - named parameter null
     *
     * @since  2020-01-01
     */
    public function containerGetNamedParameterNull(UnitTester $I)
    {
        $I->wantToTest('Container - get() - named parameter null');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->parameters()
            ->set(
                NullParentConstructClass::class,
                [
                    'store' => null,
                ]
            )
        ;
        $container->set(
            'parentService',
            $container->lazyNew(NullParentConstructClass::class)
        );

        $service = $container->get('parentService');
        $I->assertInstanceOf(NullParentConstructClass::class, $service);
    }

    /**
     * Unit Tests Phalcon\Container :: get() - numbered parameter null
     *
     * @since  2020-01-01
     */
    public function containerGetNumberedParameterNull(UnitTester $I)
    {
        $I->wantToTest('Container - get() - numbered parameter null');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->parameters()
            ->set(
                NullParentConstructClass::class,
                [
                    null,
                ]
            )
        ;
        $container->set(
            'parentService',
            $container->lazyNew(NullParentConstructClass::class)
        );

        $service = $container->get('parentService');
        $I->assertInstanceOf(NullParentConstructClass::class, $service);
    }

    /**
     * Unit Tests Phalcon\Container :: get() - implicit parent parameter null
     *
     * @since  2020-01-01
     */
    public function containerGetImplicitParentParameterNull(UnitTester $I)
    {
        $I->wantToTest('Container - get() - implicit parent parameter null');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container
            ->parameters()
            ->set(
                NullParentConstructClass::class,
                [
                    null,
                ]
            )
        ;
        $container->set(
            'parentService',
            $container->lazyNew(NullParentConstructClass::class)
        );

        $container->set(
            'childService',
            $container->lazyNew(NullChildConstructClass::class)
        );

        $service = $container->get('childService');
        $I->assertInstanceOf(NullParentConstructClass::class, $service);
    }
}

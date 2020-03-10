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
use Phalcon\Container\Exception\ContainerLocked;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use stdClass;
use UnitTester;

class LockCest
{
    /**
     * Unit Tests Phalcon\Container :: lock()
     *
     * @since  2020-01-01
     */
    public function containerLock(UnitTester $I)
    {
        $I->wantToTest('Container - lock()');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $I->assertFalse($container->isLocked());
        $container->lock();
        $I->assertTrue($container->isLocked());
    }

    /**
     * Unit Tests Phalcon\Container :: lock() - newInstance
     *
     * @since  2020-01-01
     */
    public function containerLockNewInstance(UnitTester $I)
    {
        $I->wantToTest('Container - lock() - newInstance');


        $builder   = new Builder();
        $container = $builder->newInstance();
        $I->assertFalse($container->isLocked());
        $instance = $container->newInstance(OtherFixtureClass::class);
        $I->assertTrue($container->isLocked());
    }

    /**
     * Unit Tests Phalcon\Container :: lock() - exception
     *
     * @since  2020-01-01
     */
    public function containerLockException(UnitTester $I)
    {
        $I->wantToTest('Container - lock() - exception');

        $I->expectThrowable(
            new ContainerLocked(
                'Cannot modify container when locked.'
            ),
            function () {
                $builder   = new Builder();
                $container = $builder->newInstance();
                $container->lock();

                $container->set(
                    'name',
                    function () {
                        return new stdClass();
                    }
                );
            }
        );
    }
}

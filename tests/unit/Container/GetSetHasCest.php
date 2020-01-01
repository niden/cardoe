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
use Phalcon\Container\Exception\ServiceNotObject;
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
}

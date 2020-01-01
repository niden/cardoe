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
use stdClass;
use UnitTester;

class GetServicesCest
{
    /**
     * Unit Tests Phalcon\Container :: getServices()
     *
     * @since  2020-01-01
     */
    public function containerGetServices(UnitTester $I)
    {
        $I->wantToTest('Container - getServices()');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $container->set('one', (object) []);
        $container->set('two', (object) []);
        $container->set('three', (object) []);

        $expect = ['one', 'two', 'three'];

        $actual = $container->getServices();
        $I->assertEquals($expect, $actual);

        $actual = $container->get('one');
        $I->assertInstanceOf(stdClass::class, $actual);
    }
}

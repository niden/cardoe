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

class GetInstancesCest
{
    /**
     * Unit Tests Phalcon\Container :: getInstances()
     *
     * @since  2020-01-01
     */
    public function containerGetInstances(UnitTester $I)
    {
        $I->wantToTest('Container - getInstances()');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $container->set('one', (object) []);
        $container->set('two', (object) []);
        $container->set('three', (object) []);

        $actual = $container->getInstances();
        $I->assertIsArray($actual);
        $I->assertEmpty($actual);

        $actual = $container->get('one');
        $I->assertInstanceOf(stdClass::class, $actual);
    }
}

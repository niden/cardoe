<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Service\Services;

use Phalcon\Container;
use Phalcon\Container\Service\Services;
use Phalcon\Test\Fixtures\Container\OneClass;
use UnitTester;

class AddCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services :: add()
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesAdd(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - add()');

        $container = new Container();
        $services  = new Services();
        $services->setContainer($container);

        $services->add('one', OneClass::class, true);
        $services->add('two', OneClass::class);

        $oneOne = $services->get('one');
        $oneTwo = $services->get('one');
        $twoOne = $services->get('two');
        $twoTwo = $services->get('two');

        $I->assertEquals("one", $oneOne->getName());
        $I->assertEquals("one", $oneTwo->getName());
        $I->assertEquals("two", $twoOne->getName());
        $I->assertEquals("two", $twoTwo->getName());

        $I->assertEquals(
            spl_object_hash($oneOne->resolveService()),
            spl_object_hash($oneTwo->resolveService())
        );

        $I->assertNotEquals(
            spl_object_hash($twoOne->resolveService()),
            spl_object_hash($twoTwo->resolveService())
        );
    }
}

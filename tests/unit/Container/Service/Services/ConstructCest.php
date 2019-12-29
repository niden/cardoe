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

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services :: __construct()
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - __construct()');

        $services = new Services();
        $I->assertInstanceOf(Services::class, $services);
    }

    /**
     * Unit Tests Phalcon\Container\Service\Services :: __construct() - service
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesConstructService(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - __construct() - service');

        $container = new Container();
        $services  = new Services(
            [
                'one' => OneClass::class,
            ]
        );
        $services->setContainer($container);

        $I->assertTrue($services->has('one'));
        $I->assertEquals("one", $services->get('one')->getName());
    }

    /**
     * Unit Tests Phalcon\Container\Service\Services :: __construct() - services
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesConstructServices(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - __construct() - services');

        $container = new Container();
        $services  = new Services(
            [
                'one' => OneClass::class,
                'two' => OneClass::class,
            ]
        );
        $services->setContainer($container);

        $I->assertTrue($services->has('one'));
        $I->assertEquals("one", $services->get('one')->getName());
        $I->assertTrue($services->has('two'));
        $I->assertEquals("two", $services->get('two')->getName());
    }

    /**
     * Unit Tests Phalcon\Container\Service\Services :: __construct() -
     * services shared
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesConstructServicesShared(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - __construct() - services shared');

        $container = new Container();
        $services  = new Services(
            [
                'one' => [
                    'definition' => OneClass::class,
                    'shared'     => true,
                ],
                'two' => OneClass::class,
            ]
        );
        $services->setContainer($container);

        $I->assertTrue($services->has('one'));
        $I->assertEquals("one", $services->get('one')->getName());
        $I->assertTrue($services->has('two'));
        $I->assertEquals("two", $services->get('two')->getName());

        $oneOne = $services->resolve('one');
        $oneTwo = $services->resolve('one');
        $twoOne = $services->resolve('two');
        $twoTwo = $services->resolve('two');

        $I->assertEquals(spl_object_hash($oneOne), spl_object_hash($oneTwo));
        $I->assertNotEquals(spl_object_hash($twoOne), spl_object_hash($twoTwo));
    }
}

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
use Phalcon\Container\Service\Service;
use Phalcon\Container\Service\Services;
use Phalcon\Test\Fixtures\Container\OneClass;
use UnitTester;

class GetCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services :: get()
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesGet(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - get()');

        $container = new Container();
        $services  = new Services();
        $services->setContainer($container);

        $services->add('one', OneClass::class);
        $I->assertTrue($services->has('one'));

        $class = $services->get('one');
        $I->assertInstanceOf(Service::class, $class);
        $I->assertEquals("one", $class->getName());
    }

    /**
     * Unit Tests Phalcon\Container\Service\Services :: get() - exception
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesGetException(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - get() - exception');

        $I->expectThrowable(
            new Container\Exception\NotFoundException(
                '[unknown] is not a registered definition'
            ),
            function () {
                $services = new Services();
                $services->get('unknown');
            }
        );
    }
}

<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Service\Service;

use Phalcon\Container\Service\Service;
use UnitTester;

class IsSetSharedCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Service :: isShared()
     *
     * @since  2019-12-28
     */
    public function containerServiceServiceIsShared(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Service - isShared()/setShared()');

        $service = new Service('helloService');
        $I->assertFalse($service->isShared());

        $actual = $service->setShared(true);
        $I->assertInstanceOf(Service::class, $actual);

        $I->assertTrue($service->isShared());
    }
}

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
use Phalcon\Test\Fixtures\Container\OneClass;
use Phalcon\Test\Fixtures\Container\ThreeClass;
use Phalcon\Test\Fixtures\Container\TwoClass;
use UnitTester;

class AddArgumentCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Service :: addArgument()
     *
     * @since  2019-12-28
     */
    public function containerServiceServiceAddArgument(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Service - addArgument()');

        $service = new Service(
            'threeService',
            new ThreeClass()
        );
        $actual  = $service->addArgument(new TwoClass());
        $I->assertInstanceOf(Service::class, $actual);

        $actual = $service->resolveService();
        $I->assertInstanceOf(OneClass::class, $actual);
    }
}

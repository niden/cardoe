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

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Service :: __construct()
     *
     * @since  2019-12-28
     */
    public function containerServiceServiceConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Service - __construct()');

        $service = new Service('helloService');

        $I->assertInstanceOf(Service::class, $service);
    }
}

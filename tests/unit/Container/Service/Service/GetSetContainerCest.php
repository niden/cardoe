<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Service\Service;

use Phalcon\Container;
use Phalcon\Container\Service\Service;
use UnitTester;

class GetSetContainerCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Service :: getContainer()/setContainer()
     *
     * @since  2019-12-28
     */
    public function containerServiceServiceGetDryContainer(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Service - getContainer()/setContainer()');

        $container = new Container();
        $service   = new Service('service');

        $service->setContainer($container);
        $I->assertEquals($container, $service->getContainer());
    }
}

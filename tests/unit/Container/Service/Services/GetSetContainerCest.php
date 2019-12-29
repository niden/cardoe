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
use UnitTester;

class GetSetContainerCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services ::
     * getContainer()/setContainer()
     *
     * @param UnitTester $I
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesGetSetContainer(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - getContainer()/setContainer()');

        $container = new Container();
        $services  = new Services();

        $services->setContainer($container);
        $I->assertEquals($container, $services->getContainer());
    }
}

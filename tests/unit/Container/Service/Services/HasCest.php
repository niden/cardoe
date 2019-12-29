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

class HasCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services :: has()
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesHas(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - has()');

        $container = new Container();
        $services  = new Services();
        $services->setContainer($container);

        $services->add('one', OneClass::class);

        $I->assertTrue($services->has('one'));
        $I->assertFalse($services->has('unknown'));
    }
}

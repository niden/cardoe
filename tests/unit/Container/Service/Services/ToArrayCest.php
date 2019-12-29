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

class ToArrayCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services :: toArray()
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesToArray(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - toArray()');

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
        $I->assertIsArray($services->toArray());
        $I->assertCount(2, $services->toArray());
    }
}

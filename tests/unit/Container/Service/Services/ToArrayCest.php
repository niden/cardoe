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

class GetIteratorCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services :: getIterator()
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesGetIterator(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - getIterator()');

        $container = new Container();
        $services = new Services(
            [
                'one' => [
                    'definition' => OneClass::class,
                    'shared'     => true,
                ],
                'two' => OneClass::class,
            ]
        );
        $services->setContainer($container);

        $I->assertCount(2, $services->getIterator());
    }
}

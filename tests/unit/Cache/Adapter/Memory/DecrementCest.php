<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Memory;

use Cardoe\Cache\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class DecrementCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Memory :: decrement()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryDecrement(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - decrement()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $key = uniqid();

        $I->assertTrue(
            $adapter->set($key, 100)
        );


        $expected = 99;

        $I->assertEquals(
            $expected,
            $adapter->decrement($key)
        );

        $I->assertEquals(
            $expected,
            $adapter->get($key)
        );


        $expected = 90;

        $I->assertEquals(
            $expected,
            $adapter->decrement($key, 9)
        );

        $I->assertEquals(
            $expected,
            $adapter->get($key)
        );
    }
}

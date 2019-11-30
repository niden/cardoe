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

class IncrementCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Memory :: increment()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryIncrement(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - increment()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $key = 'cache-data';

        $I->assertTrue(
            $adapter->set($key, 1)
        );

        $expected = 2;

        $I->assertEquals(
            $expected,
            $adapter->increment($key)
        );

        $I->assertEquals(
            $expected,
            $adapter->get($key)
        );

        $expected = 10;

        $I->assertEquals(
            $expected,
            $adapter->increment($key, 8)
        );

        $I->assertEquals(
            $expected,
            $adapter->get($key)
        );
    }
}

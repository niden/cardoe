<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Cache\Adapter\Memory;

use Cardoe\Cache\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class ClearCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Memory :: clear()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryClear(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - clear()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $key1 = uniqid();
        $key2 = uniqid();

        $adapter->set($key1, 'test');

        $I->assertTrue(
            $adapter->has($key1)
        );

        $adapter->set($key2, 'test');
        $I->assertTrue(
            $adapter->has($key2)
        );

        $I->assertTrue(
            $adapter->clear()
        );

        $I->assertFalse(
            $adapter->has($key1)
        );

        $I->assertFalse(
            $adapter->has($key2)
        );
    }

    /**
     * Tests Cardoe\Cache\Adapter\Memory :: clear() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryClearTwice(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - clear() - twice');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $key1 = uniqid();
        $key2 = uniqid();
        $adapter->set($key1, 'test');

        $I->assertTrue(
            $adapter->has($key1)
        );

        $adapter->set($key2, 'test');

        $I->assertTrue(
            $adapter->has($key2)
        );

        $I->assertTrue(
            $adapter->clear()
        );

        $I->assertTrue(
            $adapter->clear()
        );
    }
}
<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Libmemcached;

use Cardoe\Cache\Adapter\Libmemcached;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use UnitTester;
use function getOptionsLibmemcached;

class ClearCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Libmemcached :: clear()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterLibmemcachedClear(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Libmemcached - clear()');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $key1 = uniqid();
        $key2 = uniqid();
        $adapter->set($key1, 'test');

        $I->assertTrue(
            $adapter->has($key1)
        );

        $adapter->set($key1, 'test');

        $I->assertTrue(
            $adapter->has($key1)
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
     * Tests Cardoe\Cache\Adapter\Libmemcached :: clear() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterLibmemcachedClearTwice(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Libmemcached - clear() - twice');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $key = 'key-1';
        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );

        $key = 'key-2';
        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );

        $I->assertTrue(
            $adapter->clear()
        );

        $I->assertTrue(
            $adapter->clear()
        );
    }
}

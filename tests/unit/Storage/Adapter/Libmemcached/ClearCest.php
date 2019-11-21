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

namespace Cardoe\Test\Unit\Storage\Adapter\Libmemcached;

use Cardoe\Storage\Adapter\Libmemcached;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use UnitTester;
use function getOptionsLibmemcached;

class ClearCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Libmemcached :: clear()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterLibmemcachedClear(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - clear()');

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
     * Tests Cardoe\Storage\Adapter\Libmemcached :: clear() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterLibmemcachedClearTwice(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - clear() - twice');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $key = 'key-1';
        $adapter->set($key, 'test');
        $actual = $adapter->has($key);
        $I->assertTrue($actual);

        $key = 'key-2';
        $adapter->set($key, 'test');
        $actual = $adapter->has($key);
        $I->assertTrue($actual);

        $actual = $adapter->clear();
        $I->assertTrue($actual);

        $actual = $adapter->clear();
        $I->assertTrue($actual);
    }
}

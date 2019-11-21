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

namespace Cardoe\Test\Unit\Storage\Adapter\Redis;

use Cardoe\Storage\Adapter\Redis;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\RedisTrait;
use UnitTester;
use function getOptionsRedis;

class ClearCest
{
    use RedisTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Redis :: clear()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterRedisClear(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Redis - clear()');

        $serializer = new SerializerFactory();

        $adapter = new Redis(
            $serializer,
            getOptionsRedis()
        );

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
     * Tests Cardoe\Storage\Adapter\Redis :: clear() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterRedisClearTwice(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Redis - clear() - twice');

        $serializer = new SerializerFactory();

        $adapter = new Redis(
            $serializer,
            getOptionsRedis()
        );

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

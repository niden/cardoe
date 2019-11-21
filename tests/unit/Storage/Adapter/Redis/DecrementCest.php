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
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\RedisTrait;
use UnitTester;
use function getOptionsRedis;

class DecrementCest
{
    use RedisTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Redis :: decrement()
     *
     * @throws Exception
     * @since  2019-03-31
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function storageAdapterRedisDecrement(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Redis - decrement()');

        $I->skipTest('Check this');

        $serializer = new SerializerFactory();

        $adapter = new Redis(
            $serializer,
            getOptionsRedis()
        );

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


        /**
         * unknown key
         */
        $key = 'unknown';

        $I->assertFalse(
            $adapter->decrement($key)
        );
    }
}

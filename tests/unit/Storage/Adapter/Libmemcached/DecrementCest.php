<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Libmemcached;

use Cardoe\Storage\Adapter\Libmemcached;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use UnitTester;

use function getOptionsLibmemcached;

class DecrementCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Libmemcached :: decrement()
     *
     * @throws Exception
     * @since  2019-03-31
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function storageAdapterLibmemcachedDecrement(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - decrement()');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );


        $key = 'cache-data';

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

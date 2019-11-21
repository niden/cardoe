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

namespace Cardoe\Test\Unit\Cache\Adapter\Apcu;

use Cardoe\Cache\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class ClearCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Apcu :: clear()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterApcuClear(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - clear()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

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
     * Tests Cardoe\Cache\Adapter\Apcu :: clear() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterApcuClearTwice(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - clear() - twice');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

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

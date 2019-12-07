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

namespace Cardoe\Test\Unit\Cache\Adapter\Libmemcached;

use Cardoe\Cache\Adapter\Libmemcached;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use UnitTester;

use function getOptionsLibmemcached;

class DeleteCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Libmemcached :: delete()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterLibmemcachedDelete(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Libmemcached - delete()');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $key = 'cache-data';
        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );

        $I->assertTrue(
            $adapter->delete($key)
        );

        $I->assertFalse(
            $adapter->has($key)
        );
    }

    /**
     * Tests Cardoe\Cache\Adapter\Libmemcached :: delete() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterLibmemcachedDeleteTwice(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Libmemcached - delete() - twice');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $key = 'cache-data';
        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );

        $I->assertTrue(
            $adapter->delete($key)
        );

        $I->assertFalse(
            $adapter->delete($key)
        );
    }

    /**
     * Tests Cardoe\Cache\Adapter\Libmemcached :: delete() - unknown
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterLibmemcachedDeleteUnknown(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Libmemcached - delete() - unknown');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $key = 'cache-data';

        $I->assertFalse(
            $adapter->delete($key)
        );
    }
}

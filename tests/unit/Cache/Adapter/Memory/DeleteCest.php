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

namespace Cardoe\Test\Unit\Cache\Adapter\Memory;

use Cardoe\Cache\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class DeleteCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Memory :: delete()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryDelete(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - delete()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

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
     * Tests Cardoe\Cache\Adapter\Memory :: delete() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryDeleteTwice(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - delete() - twice');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

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
     * Tests Cardoe\Cache\Adapter\Memory :: delete() - unknown
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryDeleteUnknown(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - delete() - unknown');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $key = 'cache-data';

        $I->assertFalse(
            $adapter->delete($key)
        );
    }
}

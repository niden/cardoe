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

namespace Cardoe\Test\Unit\Cache\Cache;

use Cardoe\Cache;
use Cardoe\Cache\AdapterFactory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;
use function uniqid;

class ClearCest
{
    /**
     * Tests Cardoe\Cache :: clear()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-01
     */
    public function cacheCacheClear(UnitTester $I)
    {
        $I->wantToTest('Cache\Cache - clear()');

        $serializer = new SerializerFactory();
        $factory    = new AdapterFactory($serializer);
        $instance   = $factory->newInstance('apcu');

        $adapter = new Cache($instance);

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
}

<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Cache;

use Cardoe\Cache\AdapterFactory;
use Cardoe\Cache\Cache;
use Cardoe\Cache\Exception\InvalidArgumentException;
use Cardoe\Storage\SerializerFactory;
use UnitTester;
use function uniqid;

class DeleteCest
{
    /**
     * Tests Cardoe\Cache :: delete()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-01
     */
    public function cacheCacheDelete(UnitTester $I)
    {
        $I->wantToTest('Cache\Cache - delete()');

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
            $adapter->delete($key1)
        );

        $I->assertFalse(
            $adapter->has($key1)
        );

        $I->assertTrue(
            $adapter->has($key2)
        );
    }

    /**
     * Tests Cardoe\Cache :: delete() - exception
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-01
     */
    public function cacheCacheDeleteException(UnitTester $I)
    {
        $I->wantToTest('Cache\Cache - delete() - exception');

        $I->expectThrowable(
            new InvalidArgumentException('The key contains invalid characters'),
            function () {
                $serializer = new SerializerFactory();
                $factory    = new AdapterFactory($serializer);
                $instance   = $factory->newInstance('apcu');

                $adapter = new Cache($instance);
                $value   = $adapter->delete('abc$^');
            }
        );
    }
}

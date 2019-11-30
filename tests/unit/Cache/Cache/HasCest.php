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

class HasCest
{
    /**
     * Tests Cardoe\Cache :: has()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-01
     */
    public function cacheCacheHas(UnitTester $I)
    {
        $I->wantToTest('Cache\Cache - has()');

        $serializer = new SerializerFactory();
        $factory    = new AdapterFactory($serializer);
        $instance   = $factory->newInstance('apcu');

        $adapter = new Cache($instance);

        $key = uniqid();

        $I->assertFalse(
            $adapter->has($key)
        );

        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );
    }

    /**
     * Tests Cardoe\Cache :: has() - exception
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-01
     */
    public function cacheCacheHasException(UnitTester $I)
    {
        $I->wantToTest('Cache\Cache - has() - exception');

        $I->expectThrowable(
            new InvalidArgumentException('The key contains invalid characters'),
            function () {
                $serializer = new SerializerFactory();
                $factory    = new AdapterFactory($serializer);
                $instance   = $factory->newInstance('apcu');

                $adapter = new Cache($instance);

                $value = $adapter->has('abc$^');
            }
        );
    }
}

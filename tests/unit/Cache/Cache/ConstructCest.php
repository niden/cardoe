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

namespace Cardoe\Test\Unit\Cache\Cache;

use Cardoe\Cache\Cache;
use Cardoe\Cache\AdapterFactory;
use Cardoe\Storage\SerializerFactory;
use Psr\SimpleCache\CacheInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Cache :: __construct()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-01
     */
    public function cacheCacheConstruct(UnitTester $I)
    {
        $I->wantToTest('Cache\Cache - __construct()');

        $serializer = new SerializerFactory();
        $factory    = new AdapterFactory($serializer);
        $options = [
            'defaultSerializer' => 'Json',
            'lifetime'          => 7200
        ];

        $instance   = $factory->newInstance('apcu', $options);

        $adapter = new Cache($instance);

        $I->assertInstanceOf(
            Cache::class,
            $adapter
        );

        $I->assertInstanceOf(
            CacheInterface::class,
            $adapter
        );
    }
}

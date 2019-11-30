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

namespace Cardoe\Test\Unit\Cache\CacheFactory;

use Cardoe\Cache\AdapterFactory;
use Cardoe\Cache\Cache;
use Cardoe\Cache\CacheFactory;
use Cardoe\Storage\SerializerFactory;
use Psr\SimpleCache\CacheInterface;
use UnitTester;

class NewInstanceCest
{
    /**
     * Tests Cardoe\Cache\CacheFactory :: newInstance()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-03
     */
    public function cacheCacheFactoryNewInstance(UnitTester $I)
    {
        $I->wantToTest('Cache\CacheFactory - newInstance()');

        $serializer     = new SerializerFactory();
        $adapterFactory = new AdapterFactory($serializer);
        $cacheFactory   = new CacheFactory($adapterFactory);
        $adapter        = $cacheFactory->newInstance('apcu');

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

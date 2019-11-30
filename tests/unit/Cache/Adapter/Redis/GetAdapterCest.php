<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Redis;

use Cardoe\Cache\Adapter\Redis;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\RedisTrait;
use UnitTester;
use function getOptionsRedis;

class GetAdapterCest
{
    use RedisTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Redis :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-14
     */
    public function cacheAdapterRedisGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Redis - getAdapter()');

        $serializer = new SerializerFactory();
        $adapter    = new Redis($serializer, getOptionsRedis());

        $class  = \Redis::class;
        $actual = $adapter->getAdapter();
        $I->assertInstanceOf($class, $actual);
    }
}

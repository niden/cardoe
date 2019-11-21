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

namespace Cardoe\Test\Unit\Cache\Adapter\Redis;

use Cardoe\Cache\Adapter\Redis;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\RedisTrait;
use UnitTester;
use function getOptionsRedis;

class GetPrefixCest
{
    use RedisTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Redis :: getPrefix()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterRedisGetSetPrefix(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Redis - getPrefix()');

        $serializer = new SerializerFactory();
        $adapter    = new Redis(
            $serializer,
            array_merge(
                getOptionsRedis(),
                [
                    'prefix' => 'my-prefix',
                ]
            )
        );

        $expected = 'my-prefix';
        $actual   = $adapter->getPrefix();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Cache\Adapter\Redis :: getPrefix() - default
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterRedisGetSetPrefixDefault(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Redis - getPrefix() - default');

        $serializer = new SerializerFactory();
        $adapter    = new Redis($serializer, getOptionsRedis());

        $expected = 'ph-reds-';
        $actual   = $adapter->getPrefix();
        $I->assertEquals($expected, $actual);
    }
}

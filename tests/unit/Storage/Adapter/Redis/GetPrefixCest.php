<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Redis;

use Cardoe\Storage\Adapter\Redis;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\RedisTrait;
use UnitTester;

use function getOptionsRedis;

class GetPrefixCest
{
    use RedisTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Redis :: getPrefix()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterRedisGetSetPrefix(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Redis - getPrefix()');

        $serializer = new SerializerFactory();

        $adapter = new Redis(
            $serializer,
            array_merge(
                getOptionsRedis(),
                [
                    'prefix' => 'my-prefix',
                ]
            )
        );

        $I->assertEquals(
            'my-prefix',
            $adapter->getPrefix()
        );
    }

    /**
     * Tests Cardoe\Storage\Adapter\Redis :: getPrefix() - default
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterRedisGetSetPrefixDefault(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Redis - getPrefix() - default');

        $serializer = new SerializerFactory();

        $adapter = new Redis(
            $serializer,
            getOptionsRedis()
        );

        $I->assertEquals(
            'ph-reds-',
            $adapter->getPrefix()
        );
    }
}

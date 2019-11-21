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

namespace Cardoe\Test\Unit\Storage\Adapter\Redis;

use Cardoe\Storage\Adapter\AdapterInterface;
use Cardoe\Storage\Adapter\Redis;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\RedisTrait;
use UnitTester;
use function getOptionsRedis;

class ConstructCest
{
    use RedisTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Redis :: __construct()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-09
     */
    public function storageAdapterRedisConstruct(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Redis - __construct()');

        $serializer = new SerializerFactory();

        $adapter = new Redis(
            $serializer,
            getOptionsRedis()
        );

        $I->assertInstanceOf(
            Redis::class,
            $adapter
        );

        $I->assertInstanceOf(
            AdapterInterface::class,
            $adapter
        );
    }

    /**
     * Tests Cardoe\Storage\Adapter\Redis :: __construct() - invalid serializer
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-09
     */
    public function storageAdapterRedisConstructInvalidSerializerException(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Redis - __construct() - invalid serializer exception');

        $I->expectThrowable(
            new Exception('A valid serializer is required'),
            function () {
                $adapter = new Redis(
                    null,
                    getOptionsRedis()
                );

                $adapter->setDefaultSerializer('base64');

                $value = $adapter->get('test');
            }
        );
    }
}

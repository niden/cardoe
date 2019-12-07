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

namespace Cardoe\Test\Unit\Cache\AdapterFactory;

use Codeception\Example;
use Cardoe\Cache\Adapter\Apcu;
use Cardoe\Cache\Adapter\Libmemcached;
use Cardoe\Cache\Adapter\Memory;
use Cardoe\Cache\Adapter\Redis;
use Cardoe\Cache\Adapter\Stream;
use Cardoe\Cache\AdapterFactory;
use Cardoe\Factory\Exception;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Storage\Serializer\Json;
use UnitTester;

use function getOptionsLibmemcached;
use function getOptionsRedis;
use function outputDir;

class NewInstanceCest
{
    /**
     * Tests Cardoe\Cache\AdapterFactory :: newInstance()
     *
     * @dataProvider getExamples
     *
     * @throws Exception
     * @since        2019-05-04
     *
     * @author       Cardoe Team <team@phalcon.io>
     */
    public function cacheAdapterFactoryNewInstance(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\AdapterFactory - newInstance() - ' . $example[0]);

        $serializer = new SerializerFactory();
        $adapter    = new AdapterFactory($serializer);

        $service = $adapter->newInstance($example[0], $example[2]);

        $I->assertInstanceOf(
            $example[1],
            $service
        );

        // Given `serializer` parameter
        $adapter = new AdapterFactory();
        $service = $adapter->newInstance($example[0], $example[3]);

        $I->assertInstanceOf(
            $example[1],
            $service
        );
    }

    /**
     * Tests Cardoe\Storage\SerializerFactory :: newInstance() - exception
     *
     * @throws Exception
     * @since  2019-05-04
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function storageSerializerFactoryNewInstanceException(UnitTester $I)
    {
        $I->wantToTest('Storage\SerializerFactory - newInstance() - exception');

        $I->expectThrowable(
            new Exception('Service unknown is not registered'),
            function () {
                $serializer = new SerializerFactory();
                $adapter    = new AdapterFactory($serializer);

                $service = $adapter->newInstance('unknown');
            }
        );
    }

    private function getExamples(): array
    {
        $jsonSerializer = new Json();
        $optionsWithSerializer = [
            'serializer' => $jsonSerializer
        ];
        return [
            [
                'apcu',
                Apcu::class,
                [],
                $optionsWithSerializer,
            ],
            [
                'libmemcached',
                Libmemcached::class,
                getOptionsLibmemcached(),
                array_merge(getOptionsLibmemcached(), $optionsWithSerializer),
            ],
            [
                'memory',
                Memory::class,
                [],
                $optionsWithSerializer
            ],
            [
                'redis',
                Redis::class,
                getOptionsRedis(),
                array_merge(getOptionsRedis(), $optionsWithSerializer)
            ],
            [
                'stream',
                Stream::class,
                [
                    'storageDir' => outputDir(),
                ],
                [
                    'storageDir' => outputDir(),
                    'serializer' => $jsonSerializer,
                ],
            ],
        ];
    }
}

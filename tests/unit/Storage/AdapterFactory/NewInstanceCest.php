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

namespace Cardoe\Test\Unit\Storage\AdapterFactory;

use Codeception\Example;
use Cardoe\Factory\Exception;
use Cardoe\Storage\Adapter\Apcu;
use Cardoe\Storage\Adapter\Libmemcached;
use Cardoe\Storage\Adapter\Memory;
use Cardoe\Storage\Adapter\Redis;
use Cardoe\Storage\Adapter\Stream;
use Cardoe\Storage\AdapterFactory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;
use function getOptionsLibmemcached;
use function getOptionsRedis;
use function outputDir;

class NewInstanceCest
{
    /**
     * Tests Cardoe\Storage\AdapterFactory :: newInstance()
     *
     * @dataProvider getExamples
     *
     * @throws Exception
     * @since        2019-05-04
     *
     * @author       Cardoe Team <team@phalcon.io>
     */
    public function storageAdapterFactoryNewInstance(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\AdapterFactory - newInstance() - ' . $example[0]);

        $serializer = new SerializerFactory();
        $adapter    = new AdapterFactory($serializer);

        $service = $adapter->newInstance($example[0], $example[2]);

        $class = $example[1];
        $I->assertInstanceOf($class, $service);
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
        return [
            [
                'apcu',
                Apcu::class,
                [],
            ],
            [
                'libmemcached',
                Libmemcached::class,
                getOptionsLibmemcached(),
            ],
            [
                'memory',
                Memory::class,
                [],
            ],
            [
                'redis',
                Redis::class,
                getOptionsRedis(),
            ],
            [
                'stream',
                Stream::class,
                [
                    'storageDir' => outputDir(),
                ],
            ],
        ];
    }
}

<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\SerializerFactory;

use Cardoe\Factory\Exception;
use Cardoe\Storage\Serializer\Base64;
use Cardoe\Storage\Serializer\Igbinary;
use Cardoe\Storage\Serializer\Json;
use Cardoe\Storage\Serializer\Msgpack;
use Cardoe\Storage\Serializer\None;
use Cardoe\Storage\Serializer\Php;
use Cardoe\Storage\SerializerFactory;
use Codeception\Example;
use UnitTester;

class NewInstanceCest
{
    /**
     * Tests Cardoe\Storage\SerializerFactory :: newInstance()
     *
     * @dataProvider getExamples
     *
     * @throws Exception
     * @since        2019-05-04
     *
     * @author       Cardoe Team <team@phalcon.io>
     */
    public function storageSerializerFactoryNewInstance(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\SerializerFactory - newInstance() - ' . $example[0]);

        $factory = new SerializerFactory();
        $service = $factory->newInstance($example[0]);

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
                $factory = new SerializerFactory();
                $service = $factory->newInstance('unknown');
            }
        );
    }

    private function getExamples(): array
    {
        return [
            ['base64', Base64::class],
            ['igbinary', Igbinary::class],
            ['json', Json::class],
            ['msgpack', Msgpack::class],
            ['none', None::class],
            ['php', Php::class],
        ];
    }
}

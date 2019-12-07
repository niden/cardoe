<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Serializer\Msgpack;

use Cardoe\Storage\Serializer\Msgpack;
use Codeception\Example;
use stdClass;
use UnitTester;

class UnserializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Msgpack :: unserialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalcon.io>
     * @since        2019-03-30
     */
    public function storageSerializerMsgpackUnserialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Serializer\Msgpack - unserialize() - ' . $example[0]);
        $serializer = new Msgpack();
        $serialized = msgpack_pack($example[1]);
        $serializer->unserialize($serialized);

        $expected = $example[1];
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Storage\Serializer\Msgpack :: unserialize() - error
     *
     * @author       Cardoe Team <team@phalcon.io>
     * @since        2019-09-28
     */
    public function storageSerializerMsgpackUnserializeError(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Msgpack - unserialize() - error');
        $serializer = new Msgpack();

        $serialized = '??hello?messagepack"';
        $serializer->unserialize($serialized);

        $I->assertEmpty($serializer->getData());
    }

    private function getExamples(): array
    {
        return [
            [
                'integer',
                1234,
            ],
            [
                'float',
                1.234,
            ],
            [
                'string',
                'Cardoe Framework',
            ],
            [
                'array',
                ['Cardoe Framework'],
            ],
            [
                'object',
                new stdClass(),
            ],
        ];
    }
}

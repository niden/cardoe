<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

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
     * @author       Cardoe Team <team@phalconphp.com>
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

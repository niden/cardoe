<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Serializer\Igbinary;

use Cardoe\Storage\Serializer\Igbinary;
use Codeception\Example;
use stdClass;
use UnitTester;

use function igbinary_serialize;

class SerializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Igbinary :: serialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalcon.io>
     * @since        2019-03-30
     */
    public function storageSerializerIgbinarySerialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Serializer\Igbinary - serialize() - ' . $example[0]);

        $serializer = new Igbinary($example[1]);

        $expected = $example[2];

        $I->assertEquals(
            $expected,
            $serializer->serialize()
        );
    }

    private function getExamples(): array
    {
        return [
            [
                'null',
                null,
                null,
            ],
            [
                'true',
                true,
                true,
            ],
            [
                'false',
                false,
                false,
            ],
            [
                'integer',
                1234,
                1234,
            ],
            [
                'float',
                1.234,
                1.234,
            ],
            [
                'string',
                'Cardoe Framework',
                igbinary_serialize('Cardoe Framework'),
            ],
            [
                'array',
                ['Cardoe Framework'],
                igbinary_serialize(['Cardoe Framework']),
            ],
            [
                'object',
                new stdClass(),
                igbinary_serialize(new stdClass()),
            ],
        ];
    }
}

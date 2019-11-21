<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Php;

use Cardoe\Storage\Serializer\Php;
use Codeception\Example;
use stdClass;
use UnitTester;
use function serialize;

class SerializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Php :: serialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalcon.io>
     * @since        2019-03-30
     */
    public function storageSerializerPhpSerialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Serializer\Php - serialize() - ' . $example[0]);

        $serializer = new Php($example[1]);

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
                serialize('Cardoe Framework'),
            ],
            [
                'array',
                ['Cardoe Framework'],
                serialize(['Cardoe Framework']),
            ],
            [
                'object',
                new stdClass(),
                serialize(new stdClass()),
            ],
        ];
    }
}

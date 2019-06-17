<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Json;

use Cardoe\Storage\Serializer\Json;
use Codeception\Example;
use stdClass;
use UnitTester;

class SerializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Json :: serialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalconphp.com>
     * @since        2019-03-30
     */
    public function storageSerializerJsonSerialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Serializer\Json - serialize() - ' . $example[0]);
        $serializer = new Json($example[1]);

        $expected = $example[2];
        $actual   = $serializer->serialize();
        $I->assertEquals($expected, $actual);
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
                '"Cardoe Framework"',
            ],
            [
                'array',
                ['Cardoe Framework'],
                '["Cardoe Framework"]',
            ],
            [
                'object',
                new stdClass(),
                '{}',
            ],
        ];
    }
}

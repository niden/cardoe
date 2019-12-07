<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Serializer\Json;

use Cardoe\Storage\Serializer\Json;
use Codeception\Example;
use stdClass;
use UnitTester;

class UnserializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Json :: unserialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalcon.io>
     * @since        2019-03-30
     */
    public function storageSerializerJsonUnserialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Serializer\Json - unserialize() - ' . $example[0]);
        $serializer = new Json();
        $serialized = json_encode($example[1]);
        $serializer->unserialize($serialized);

        $expected = $example[1];
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }

    private function getExamples(): array
    {
        return [
            [
                'null',
                null,
            ],
            [
                'true',
                true,
            ],
            [
                'false',
                false,
            ],
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

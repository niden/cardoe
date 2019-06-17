<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\None;

use Cardoe\Storage\Serializer\None;
use Codeception\Example;
use stdClass;
use UnitTester;

class UnserializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\None :: unserialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalconphp.com>
     * @since        2019-03-30
     */
    public function storageSerializerNoneUnserialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Serializer\None - unserialize() - ' . $example[0]);
        $serializer = new None();
        $serialized = $example[1];
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

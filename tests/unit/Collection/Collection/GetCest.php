<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Collection\Collection;

use Cardoe\Collection\Collection;
use Cardoe\Helper\Arr;
use Codeception\Example;
use stdClass;
use UnitTester;

class GetCest
{
    /**
     * Tests Cardoe\Collection\Collection :: get()
     *
     * @since  2018-11-13
     */
    public function collectionGet(UnitTester $I)
    {
        $I->wantToTest('Collection\Collection - get()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new Collection($data);

        $expected = 'four';

        $I->assertEquals(
            $expected,
            $collection->get('three')
        );

        $I->assertEquals(
            $expected,
            $collection->get('THREE')
        );

        $I->assertEquals(
            $expected,
            $collection->get('unknown', 'four')
        );

        $I->assertEquals(
            $expected,
            $collection['three']
        );

        $I->assertEquals(
            $expected,
            $collection->three
        );

        $I->assertEquals(
            $expected,
            $collection->offsetGet('three')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: get() - cast
     *
     * @dataProvider getExamples
     *
     * @since  2019-10-12
     */
    public function helperArrGetCast(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Arr - get() - cast ' . $example[0]);

        $collection = new Collection(
            [
                'value' => $example[1],
            ]
        );

        $I->assertEquals(
            $example[2],
            $collection->get('value', null, $example[0])
        );
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        $sample = new stdClass();
        $sample->one = 'two';

        return [
            [
                'boolean',
                1,
                true,
            ],
            [
                'bool',
                1,
                true,
            ],
            [
                'integer',
                "123",
                123,
            ],
            [
                'int',
                "123",
                123,
            ],
            [
                'float',
                "123.45",
                123.45,
            ],
            [
                'double',
                "123.45",
                123.45,
            ],
            [
                'string',
                123,
                "123",
            ],
            [
                'array',
                $sample,
                ['one' => 'two'],
            ],
            [
                'object',
                ['one' => 'two'],
                $sample,
            ],
            [
                'null',
                1234,
                null,
            ],
        ];
    }
}

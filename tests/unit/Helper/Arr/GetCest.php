<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Arr;

use Cardoe\Helper\Arr;
use Codeception\Example;
use stdClass;
use UnitTester;

class GetCest
{
    /**
     * Tests Cardoe\Helper\Arr :: get() - numeric
     *
     * @since  2019-02-17
     */
    public function helperArrGetNumeric(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - get() - numeric');

        $collection = [
            1        => 'Cardoe',
            'suffix' => 'Framework',
        ];

        $I->assertEquals(
            'Cardoe',
            Arr::get($collection, 1, 'Error')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: get() - string
     *
     * @since  2019-02-17
     */
    public function helperArrGetString(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - get() - string');

        $collection = [
            1        => 'Cardoe',
            'suffix' => 'Framework',
        ];

        $I->assertEquals(
            'Framework',
            Arr::get($collection, 'suffix', 'Error')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: get() - default
     *
     * @since  2019-02-17
     */
    public function helperArrGetDefault(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - get() - default');

        $collection = [
            1        => 'Cardoe',
            'suffix' => 'Framework',
        ];

        $I->assertEquals(
            'Error',
            Arr::get($collection, 'unknown', 'Error')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: get() - cast
     *
     * @dataProvider getExamples
     *
     * @since        2019-10-12
     */
    public function helperArrGetCast(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Arr - get() - cast ' . $example[0]);

        $collection = [
            'value' => $example[1],
        ];

        $I->assertEquals(
            $example[2],
            Arr::get($collection, 'value', null, $example[0])
        );
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        $sample      = new stdClass();
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

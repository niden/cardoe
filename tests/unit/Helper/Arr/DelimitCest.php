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
use UnitTester;

class DelimitCest
{
    /**
     * Tests Cardoe\Helper\Arr :: delimit()
     *
     * @dataProvider getExamples
     *
     * @since        2019-11-22
     */
    public function helperArrDelimit(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Arr - delimit()');

        $results = Arr::delimit(
            $example[0],
            "=",
            2,
            $example[1]
        );

        $I->assertEquals($example[2], $results[0]);
        $I->assertEquals($example[3], $results[1]);
    }

    private function getExamples(): array
    {
        return [
            [
                'one=two',
                "urldecode",
                'one',
                'two',
            ],
            [
                'hello%3Dworld=how%22are%27you',
                "urldecode",
                'hello=world',
                'how"are\'you',
            ],
            [
                'empty=',
                "urldecode",
                'empty',
                '',
            ],
            [
                'one=two',
                null,
                'one',
                'two',
            ],
            [
                'hello%3Dworld=how%22are%27you',
                null,
                'hello%3Dworld',
                'how%22are%27you',
            ],
            [
                'empty=',
                null,
                'empty',
                '',
            ],
        ];
    }
}

<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Formatter\Line;

use Cardoe\Logger\Formatter\Line;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class InterpolateCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Line :: interpolate()
     *
     * @since  2018-11-13
     */
    public function loggerFormatterLineInterpolate(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - interpolate()');

        $formatter = new Line();

        $I->assertEquals(
            'The sky is blue',
            $formatter->interpolate(
                'The sky is {color}',
                [
                    'color' => 'blue',
                ]
            )
        );
    }

    /**
     * Tests Cardoe\Logger\Formatter\Line :: interpolate() - format
     *
     * @since  2018-11-13
     */
    public function loggerFormatterLineInterpolateFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - interpolate() - format()');

        $formatter = new Line();

        $message = 'The sky is {color}';

        $context = [
            'color' => 'blue',
        ];

        $time = time();

        $item = new Item(
            $message,
            'debug',
            Logger::DEBUG,
            $time,
            $context
        );

        $expected = sprintf('[%s][debug] The sky is blue', date('D, d M y H:i:s O', $time)) . PHP_EOL;

        $I->assertEquals(
            $expected,
            $formatter->format($item)
        );
    }

    /**
     * Tests Cardoe\Logger\Formatter\Line :: interpolate() - empty
     */
    public function loggerFormatterLineInterpolateEmpty(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - interpolate() - empty');
        $formatter = new Line();

        $message = 'The sky is {color}';
        $context = [];

        $expected = 'The sky is {color}';
        $actual   = $formatter->interpolate($message, $context);
        $I->assertEquals($expected, $actual);
    }
}

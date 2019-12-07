<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Formatter\Json;

use Cardoe\Logger\Formatter\Json;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class InterpolateCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Json :: interpolate()
     *
     * @since  2018-11-13
     */
    public function loggerFormatterJsonInterpolate(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Json - interpolate()');

        $formatter = new Json();

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
     * Tests Cardoe\Logger\Formatter\Json :: interpolate() - format
     *
     * @since  2018-11-13
     */
    public function loggerFormatterJsonInterpolateFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Json - interpolate() - format()');

        $formatter = new Json();

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

        $expected = sprintf(
            '{"type":"debug","message":"The sky is blue","timestamp":"%s"}%s',
            date('D, d M y H:i:s O', $time),
            PHP_EOL
        );

        $I->assertEquals(
            $expected,
            $formatter->format($item)
        );
    }
}

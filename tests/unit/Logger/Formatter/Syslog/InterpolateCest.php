<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Formatter\Syslog;

use Cardoe\Logger\Formatter\Syslog;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class InterpolateCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Syslog :: interpolate()
     *
     * @since  2018-11-13
     */
    public function loggerFormatterSyslogInterpolate(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Syslog - interpolate()');

        $formatter = new Syslog();

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
     * Tests Cardoe\Logger\Formatter\Syslog :: interpolate() - format
     *
     * @since  2018-11-13
     */
    public function loggerFormatterSyslogInterpolateFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Syslog - interpolate() - format()');

        $formatter = new Syslog();

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

        $I->assertEquals(
            [
                Logger::DEBUG,
                'The sky is blue',
            ],
            $formatter->format($item)
        );
    }
}

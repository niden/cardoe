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

class FormatCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Syslog :: format()
     */
    public function loggerFormatterSyslogFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Syslog - format()');
        $formatter = new Syslog();

        $time = time();
        $item = new Item('log message', 'debug', Logger::DEBUG, $time);

        $expected = [Logger::DEBUG, 'log message'];
        $actual   = $formatter->format($item);
        $I->assertEquals($expected, $actual);
    }
}

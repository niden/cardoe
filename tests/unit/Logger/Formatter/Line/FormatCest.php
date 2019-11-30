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
use const PHP_EOL;

class FormatCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Line :: format()
     *
     * @since  2018-11-13
     */
    public function loggerFormatterLineFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - format()');

        $formatter = new Line();

        $time = time();

        $item = new Item(
            'log message',
            'debug',
            Logger::DEBUG,
            $time
        );

        $expected = sprintf('[%s][debug] log message', date('D, d M y H:i:s O', $time)) . PHP_EOL;

        $I->assertEquals(
            $expected,
            $formatter->format($item)
        );
    }

    /**
     * Tests Cardoe\Logger\Formatter\Line :: format() -custom
     *
     * @since  2018-11-13
     */
    public function loggerFormatterLineFormatCustom(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - format() - custom');

        $formatter = new Line('%message%-[%type%]-%date%');

        $time = time();

        $item = new Item(
            'log message',
            'debug',
            Logger::DEBUG,
            $time
        );

        $expected = sprintf('log message-[debug]-%s', date('D, d M y H:i:s O', $time)) . PHP_EOL;

        $I->assertEquals(
            $expected,
            $formatter->format($item)
        );
    }
}

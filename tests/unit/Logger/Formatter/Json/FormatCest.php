<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Formatter\Json;

use Cardoe\Logger\Formatter\Json;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use const PHP_EOL;
use UnitTester;

class FormatCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Json :: format()
     *
     * @since  2018-11-13
     */
    public function loggerFormatterJsonFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Json - format()');

        $formatter = new Json();

        $time = time();

        $item = new Item(
            'log message',
            'debug',
            Logger::DEBUG,
            $time
        );

        $expected = sprintf(
            '{"type":"debug","message":"log message","timestamp":"%s"}%s',
            date('D, d M y H:i:s O', $time),
            PHP_EOL
        );

        $I->assertEquals(
            $expected,
            $formatter->format($item)
        );
    }

    /**
     * Tests Cardoe\Logger\Formatter\Json :: format() -custom
     *
     * @since  2018-11-13
     */
    public function loggerFormatterJsonFormatCustom(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Json - format() - custom');

        $formatter = new Json('YmdHis');

        $time = time();

        $item = new Item(
            'log message',
            'debug',
            Logger::DEBUG,
            $time
        );

        $expected = sprintf(
            '{"type":"debug","message":"log message","timestamp":"%s"}%s',
            date('YmdHis', $time),
            PHP_EOL
        );

        $I->assertEquals(
            $expected,
            $formatter->format($item)
        );
    }
}

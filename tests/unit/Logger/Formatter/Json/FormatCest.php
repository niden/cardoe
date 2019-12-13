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

use const PHP_EOL;

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
            date('c', $time),
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

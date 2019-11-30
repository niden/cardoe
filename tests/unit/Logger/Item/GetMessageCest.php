<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Item;

use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class GetMessageCest
{
    /**
     * Tests Cardoe\Logger\Item :: getMessage()
     */
    public function loggerItemGetMessage(UnitTester $I)
    {
        $I->wantToTest('Logger\Item - getMessage()');
        $time = time();
        $item = new Item('log message', 'debug', Logger::DEBUG, $time);

        $expected = 'log message';
        $actual   = $item->getMessage();
        $I->assertEquals($expected, $actual);
    }
}

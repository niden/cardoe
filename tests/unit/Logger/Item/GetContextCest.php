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

class GetContextCest
{
    /**
     * Tests Cardoe\Logger\Item :: getContext()
     */
    public function loggerItemGetContext(UnitTester $I)
    {
        $I->wantToTest('Logger\Item - getContext()');
        $time    = time();
        $context = ['context'];
        $item    = new Item('log message', 'debug', Logger::DEBUG, $time, $context);

        $expected = $context;
        $actual   = $item->getContext();
        $I->assertEquals($expected, $actual);
    }
}

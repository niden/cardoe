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

class GetNameCest
{
    /**
     * Tests Cardoe\Logger\Item :: getName()
     *
     * @since  2018-11-13
     */
    public function loggerItemGetName(UnitTester $I)
    {
        $I->wantToTest('Logger\Item - getName()');

        $time = time();

        $item = new Item(
            'log message',
            'debug',
            Logger::DEBUG,
            $time
        );

        $I->assertEquals(
            'debug',
            $item->getName()
        );
    }
}

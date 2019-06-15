<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Item;

use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class GetTypeCest
{
    /**
     * Tests Cardoe\Logger\Item :: getType()
     */
    public function loggerItemGetType(UnitTester $I)
    {
        $I->wantToTest('Logger\Item - getType()');
        $time = time();
        $item = new Item('log message', 'debug', Logger::DEBUG, $time);

        $expected = Logger::DEBUG;
        $actual   = $item->getType();
        $I->assertEquals($expected, $actual);
    }
}

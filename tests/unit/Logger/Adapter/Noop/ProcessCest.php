<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Adapter\Noop;

use Cardoe\Logger\Adapter\Noop;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class ProcessCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: process()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopProcess(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - process()');

        $adapter = new Noop();

        $item = new Item('Message 1', 'debug', Logger::DEBUG);

        $adapter->process($item);
    }
}
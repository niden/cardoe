<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Adapter\Syslog;

use Cardoe\Logger\Adapter\Syslog;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class ProcessCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Syslog :: process()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterSyslogProcess(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - process()');

        $streamName = $I->getNewFileName('log', 'log');

        $adapter = new Syslog($streamName);

        $item = new Item(
            'Message 1',
            'debug',
            Logger::DEBUG
        );

        $adapter->process($item);

        $I->assertTrue(
            $adapter->close()
        );
    }
}

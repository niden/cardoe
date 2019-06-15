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
use UnitTester;

class InTransactionCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Syslog :: inTransaction()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterSyslogInTransaction(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - inTransaction()');

        $streamName = $I->getNewFileName('log', 'log');

        $adapter = new Syslog($streamName);

        $adapter->begin();

        $I->assertTrue(
            $adapter->inTransaction()
        );

        $adapter->commit();

        $I->assertFalse(
            $adapter->inTransaction()
        );
    }
}

<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Adapter\Syslog;

use Cardoe\Logger\Adapter\Syslog;
use UnitTester;

class RollbackCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Syslog :: rollback()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterSyslogRollback(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - rollback()');

        $streamName = $I->getNewFileName('log', 'log');

        $adapter = new Syslog($streamName);

        $adapter->begin();

        $I->assertTrue(
            $adapter->inTransaction()
        );

        $adapter->rollback();

        $I->assertFalse(
            $adapter->inTransaction()
        );
    }
}

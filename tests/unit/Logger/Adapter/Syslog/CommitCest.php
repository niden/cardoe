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
use Cardoe\Logger\Exception;
use UnitTester;

class CommitCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Syslog :: commit()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterSyslogCommit(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - commit()');

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

    /**
     * Tests Cardoe\Logger\Adapter\Syslog :: commit() - no transaction
     *
     * @since  2018-11-13
     */
    public function loggerAdapterSyslogCommitNoTransaction(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - commit() - no transaction');

        $streamName = $I->getNewFileName('log', 'log');

        $adapter = new Syslog($streamName);

        $I->assertFalse(
            $adapter->inTransaction()
        );

        $I->expectThrowable(
            new Exception('There is no active transaction'),
            function () use ($adapter) {
                $adapter->commit();
            }
        );
    }
}

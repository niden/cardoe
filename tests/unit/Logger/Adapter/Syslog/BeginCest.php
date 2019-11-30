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

class BeginCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Syslog :: begin()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterSyslogBegin(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - begin()');

        $streamName = $I->getNewFileName('log', 'log');

        $adapter = new Syslog($streamName);

        $adapter->begin();

        $I->assertTrue(
            $adapter->inTransaction()
        );
    }
}

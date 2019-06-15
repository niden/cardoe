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

class CloseCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Syslog :: close()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterSyslogClose(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - close()');

        $streamName = $I->getNewFileName('log', 'log');

        $adapter = new Syslog($streamName);

        $I->assertTrue(
            $adapter->close()
        );
    }
}

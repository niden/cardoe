<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Adapter\Syslog;

use UnitTester;

class DestructCest
{
    /**
     * Unit Tests Cardoe\Logger\Adapter\Syslog :: __destruct()
     *
     * @since  2019-11-30
     */
    public function loggerAdapterSyslogDestruct(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - __destruct()');

        $I->skipTest('Need implementation');
    }
}

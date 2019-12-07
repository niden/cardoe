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
use Cardoe\Logger\Formatter\FormatterInterface;
use Cardoe\Logger\Formatter\Line;
use UnitTester;

class SetFormatterCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Syslog :: setFormatter()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterSyslogSetFormatter(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - setFormatter()');

        $streamName = $I->getNewFileName('log', 'log');

        $adapter = new Syslog($streamName);

        $adapter->setFormatter(
            new Line()
        );

        $I->assertInstanceOf(
            FormatterInterface::class,
            $adapter->getFormatter()
        );
    }
}

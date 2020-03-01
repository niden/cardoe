<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Logger\Adapter\Syslog;

use Codeception\Stub;
use LogicException;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Syslog;
use Phalcon\Logger\Item;
use UnitTester;

class ProcessCest
{
    /**
     * Tests Phalcon\Logger\Adapter\Syslog :: process()
     *
     * @author Phalcon Team <team@phalcon.io>
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
    
    /**
     * Tests Phalcon\Logger\Adapter\Syslog :: process() - exception
     *
     * @throws Exception
     */
    public function loggerAdapterSyslogProcessException(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Syslog - process() - exception');

        $fileName = $I->getNewFileName('log', 'log');

        $I->expectThrowable(
            new LogicException(
                "Cannot open syslog for name [" . $fileName
                . "] and facility [8]"
            ),
            function () use ($fileName) {
                $adapter = Stub::construct(
                    Syslog::class,
                    [
                        $fileName
                    ],
                    [
                        'openlog' => false,
                    ]
                );

                $item = new Item('Message 1', 'debug', Logger::DEBUG);
                $adapter->process($item);
            }
        );
    }
}

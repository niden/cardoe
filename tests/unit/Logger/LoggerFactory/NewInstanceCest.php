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

namespace Phalcon\Test\Unit\Logger\LoggerFactory;

use Phalcon\Factory\Exception;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\AdapterInterface;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;
use UnitTester;

use function logsDir;
use function outputDir;

class NewInstanceCest
{
    /**
     * Tests Phalcon\Logger\LoggerFactory :: newInstance()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2019-05-20
     */
    public function loggerLoggerFactoryNewInstance(UnitTester $I)
    {
        $I->wantToTest('Logger\LoggerFactory - newInstance()');

        $logPath  = logsDir();
        $fileName = $I->getNewFileName('log', 'log');
        $adapter  = new Stream($logPath . $fileName);
        $factory  = new LoggerFactory();
        $logger   = $factory->newInstance(
            'my-logger',
            [
                'one' => $adapter,
            ]
        );

        $I->assertInstanceOf(LoggerInterface::class, $logger);
        $I->assertInstanceOf(Logger::class, $logger);
    }
}

<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Logger;

use Cardoe\Logger\Adapter\Stream;
use Cardoe\Logger\Logger;
use UnitTester;

class LogCest
{
    /**
     * Tests Cardoe\Logger :: log()
     */
    public function loggerLog(UnitTester $I)
    {
        $I->wantToTest('Logger - log()');

        $logPath  = logsDir();
        $fileName = $I->getNewFileName('log', 'log');
        $adapter  = new Stream($logPath . $fileName);

        $logger = new Logger(
            'my-logger',
            [
                'one' => $adapter,
            ]
        );

        $levels = [
            Logger::ALERT     => 'alert',
            Logger::CRITICAL  => 'critical',
            Logger::DEBUG     => 'debug',
            Logger::EMERGENCY => 'emergency',
            Logger::ERROR     => 'error',
            Logger::INFO      => 'info',
            Logger::NOTICE    => 'notice',
            Logger::WARNING   => 'warning',
            Logger::CUSTOM    => 'custom',
            'alert'           => 'alert',
            'critical'        => 'critical',
            'debug'           => 'debug',
            'emergency'       => 'emergency',
            'error'           => 'error',
            'info'            => 'info',
            'notice'          => 'notice',
            'warning'         => 'warning',
            'custom'          => 'custom',
            'unknown'         => 'custom',
        ];

        foreach ($levels as $level => $levelName) {
            $logger->log($level, 'Message ' . $levelName);
        }

        $I->amInPath($logPath);
        $I->openFile($fileName);

        foreach ($levels as $levelName) {
            $expected = sprintf(
                '[%s][%s] Message %s',
                date('D, d M y H:i:s O'),
                $levelName,
                $levelName
            );

            $I->seeInThisFile($expected);
        }

        $I->safeDeleteFile($fileName);
    }
}

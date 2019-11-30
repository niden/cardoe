<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Fixtures\Traits;

use Cardoe\Logger\Adapter\Stream;
use Cardoe\Logger\Exception;
use Cardoe\Logger\Logger;
use UnitTester;

use function logsDir;

trait LoggerTrait
{
    /**
     * @param UnitTester $I
     * @param string     $level
     *
     * @throws Exception
     */
    protected function runLoggerFile(UnitTester $I, string $level)
    {
        $logPath = logsDir();

        $fileName = $I->getNewFileName('log', 'log');

        $adapter = new Stream(
            $logPath . $fileName
        );

        $logString = 'Hello';

        $logger = new Logger(
            'my-logger',
            [
                'one' => $adapter,
            ]
        );

        $logTime = date('D, d M y H:i:s O');

        $logger->{$level}($logString);

        $logger->getAdapter('one')->close();

        $I->amInPath($logPath);
        $I->openFile($fileName);

        $I->seeInThisFile(
            sprintf(
                '[%s][%s] ' . $logString,
                $logTime,
                $level
            )
        );

        $I->safeDeleteFile($fileName);
    }
}

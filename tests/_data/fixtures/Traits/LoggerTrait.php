<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Fixtures\Traits;

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Exception;
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
        $filePath = logsDir();
        $fileName = $I->getNewFileName('log', 'log');
        $logger   = $this->getLogger($filePath . $fileName);

        $logString = 'Hello';
        $logTime   = date('c');

        $logger->{$level}($logString);

        $logger->getAdapter('one')->close();

        $I->amInPath($filePath);
        $I->openFile($fileName);

        $I->seeInThisFile(
            sprintf(
                '[%s][%s] ' . $logString,
                $logTime,
                $level
            )
        );

        $I->safeDeleteFile($filePath . $fileName);
    }

    /**
     * @param string $fileName
     *
     * @return Logger
     * @throws Exception
     */
    protected function getLogger(string $fileName): Logger
    {
        $adapter = new Stream($fileName);

        return new Logger(
            'my-logger',
            [
                'one' => $adapter,
            ]
        );
    }
}

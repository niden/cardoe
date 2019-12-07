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

class ExcludeAdaptersCest
{
    /**
     * Tests Cardoe\Logger :: excludeAdapters()
     */
    public function loggerExcludeAdapters(UnitTester $I)
    {
        $I->wantToTest('Logger - excludeAdapters()');

        $fileName1  = $I->getNewFileName('log', 'log');
        $fileName2  = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter1   = new Stream($outputPath . $fileName1);
        $adapter2   = new Stream($outputPath . $fileName2);

        $logger = new Logger(
            'my-logger',
            [
                'one' => $adapter1,
                'two' => $adapter2,
            ]
        );

        /**
         * Log into both
         */
        $logger->debug('Hello');

        $I->amInPath($outputPath);
        $I->openFile($fileName1);
        $I->seeInThisFile('Hello');

        $I->amInPath($outputPath);
        $I->openFile($fileName2);
        $I->seeInThisFile('Hello');

        /**
         * Exclude a logger
         */
        $logger
            ->excludeAdapters(['two'])
            ->debug('Goodbye')
        ;

        $I->amInPath($outputPath);
        $I->openFile($fileName1);
        $I->seeInThisFile('Goodbye');

        $I->amInPath($outputPath);
        $I->openFile($fileName2);
        $I->dontSeeInThisFile('Goodbye');

        $I->safeDeleteFile($fileName1);
        $I->safeDeleteFile($fileName2);
    }
}

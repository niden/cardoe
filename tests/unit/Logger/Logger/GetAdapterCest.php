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
use Cardoe\Logger\Exception;
use Cardoe\Logger\Logger;
use UnitTester;

use function logsDir;

class GetAdapterCest
{
    /**
     * Tests Cardoe\Logger :: getAdapter()
     */
    public function loggerGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Logger - getAdapter()');
        $fileName1  = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter1   = new Stream($outputPath . $fileName1);

        $logger = new Logger(
            'my-logger',
            [
                'one' => $adapter1,
            ]
        );


        $class  = Stream::class;
        $actual = $logger->getAdapter('one');
        $I->assertInstanceOf($class, $actual);

        $I->safeDeleteFile($outputPath . $fileName1);
    }

    /**
     * Tests Cardoe\Logger :: getAdapter() - unknown
     */
    public function loggerGetAdapterUnknown(UnitTester $I)
    {
        $I->wantToTest('Logger - getAdapter() - unknown');

        $I->expectThrowable(
            new Exception('Adapter does not exist for this logger'),
            function () {
                $logger = new Logger('my-logger');
                $logger->getAdapter('unknown');
            }
        );
    }

    /**
     * Tests Cardoe\Logger :: getAdapter() - for transaction
     */
    public function loggerGetAdapterForTransaction(UnitTester $I)
    {
        $I->wantToTest('Logger - getAdapter() - for transaction');
        $fileName1  = $I->getNewFileName('log', 'log');
        $fileName2  = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();

        $adapter1 = new Stream($outputPath . $fileName1);
        $adapter2 = new Stream($outputPath . $fileName2);

        $logger = new Logger(
            'my-logger',
            [
                'one' => $adapter1,
                'two' => $adapter2,
            ]
        );

        $logger->info('Logging');

        $logger->getAdapter('two')->begin();

        $I->assertFalse(
            $logger->getAdapter('one')->inTransaction()
        );
        $I->assertTrue(
            $logger->getAdapter('two')->inTransaction()
        );

        $logger->info('Thanks');
        $logger->info('for');
        $logger->info('Phlying');
        $logger->info('with');
        $logger->info('Cardoe');

        $I->amInPath($outputPath);
        $I->openFile($fileName1);
        $I->seeInThisFile('Logging');
        $I->seeInThisFile('Thanks');
        $I->seeInThisFile('for');
        $I->seeInThisFile('Phlying');
        $I->seeInThisFile('with');
        $I->seeInThisFile('Cardoe');

        $I->amInPath($outputPath);
        $I->openFile($fileName2);
        $I->dontSeeInThisFile('Thanks');
        $I->dontSeeInThisFile('for');
        $I->dontSeeInThisFile('Phlying');
        $I->dontSeeInThisFile('with');
        $I->dontSeeInThisFile('Cardoe');

        $logger->getAdapter('two')->commit();

        $I->amInPath($outputPath);
        $I->openFile($fileName2);
        $I->seeInThisFile('Thanks');
        $I->seeInThisFile('for');
        $I->seeInThisFile('Phlying');
        $I->seeInThisFile('with');
        $I->seeInThisFile('Cardoe');

        $I->safeDeleteFile($outputPath . $fileName1);
        $I->safeDeleteFile($outputPath . $fileName2);
    }
}

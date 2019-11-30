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

class RemoveAdapterCest
{
    /**
     * Unit Tests Cardoe\Logger\Logger :: removeAdapter()
     */
    public function loggerRemoveAdapter(UnitTester $I)
    {
        $I->wantToTest('Logger - removeAdapter()');

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

        $expected = 2;
        $adapters = $logger->getAdapters();
        $I->assertCount($expected, $adapters);

        $logger->removeAdapter('one');
        $expected = 1;
        $adapters = $logger->getAdapters();
        $I->assertCount($expected, $adapters);

        $I->safeDeleteFile($outputPath . $fileName1);
        $I->safeDeleteFile($outputPath . $fileName2);
    }

    /**
     * Tests Cardoe\Logger :: removeAdapter() - unknown
     */
    public function loggerRemoveAdapterUnknown(UnitTester $I)
    {
        $I->wantToTest('Logger - removeAdapter() - unknown');

        $fileName1  = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();

        try {
            $adapter1 = new Stream($outputPath . $fileName1);

            $logger = new Logger(
                'my-logger',
                [
                    'one' => $adapter1,
                ]
            );

            $expected = 1;
            $adapters = $logger->getAdapters();
            $I->assertCount($expected, $adapters);

            $logger->removeAdapter('unknown');
        } catch (Exception $ex) {
            $expected = 'Adapter does not exist for this logger';
            $actual   = $ex->getMessage();
            $I->assertEquals($expected, $actual);
        }

        $I->safeDeleteFile($outputPath . $fileName1);
    }
}

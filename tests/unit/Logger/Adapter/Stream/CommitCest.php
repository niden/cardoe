<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Adapter\Stream;

use Cardoe\Logger\Adapter\Stream;
use Cardoe\Logger\Exception;
use UnitTester;

class CommitCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Stream :: commit()
     */
    public function loggerAdapterStreamCommit(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - commit()');
        $fileName   = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter    = new Stream($outputPath . $fileName);

        $adapter->begin();

        $actual = $adapter->inTransaction();
        $I->assertTrue($actual);

        $adapter->commit();

        $actual = $adapter->inTransaction();
        $I->assertFalse($actual);

        $I->safeDeleteFile($outputPath . $fileName);
    }

    /**
     * Tests Cardoe\Logger\Adapter\Stream :: commit() - no transaction
     */
    public function loggerAdapterStreamCommitNoTransaction(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - commit() - no transaction');
        $fileName   = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();

        try {
            $adapter = new Stream($outputPath . $fileName);

            $actual = $adapter->inTransaction();
            $I->assertFalse($actual);

            $adapter->commit();
        } catch (Exception $ex) {
            $expected = 'There is no active transaction';
            $actual   = $ex->getMessage();
            $I->assertEquals($expected, $actual);
        }

        $I->safeDeleteFile($outputPath . $fileName);
    }
}

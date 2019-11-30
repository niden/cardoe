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

class RollbackCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Stream :: rollback()
     *
     * @throws Exception
     */
    public function loggerAdapterStreamRollback(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - rollback()');
        $fileName   = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter    = new Stream($outputPath . $fileName);

        $adapter->begin();

        $actual = $adapter->inTransaction();
        $I->assertTrue($actual);

        $adapter->rollback();

        $actual = $adapter->inTransaction();
        $I->assertFalse($actual);

        $I->safeDeleteFile($outputPath . $fileName);
    }

    /**
     * Tests Cardoe\Logger\Adapter\Stream :: rollback() - exception
     */
    public function loggerAdapterStreamRollbackException(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - rollback() - exception');
        $I->expectThrowable(
            new Exception('There is no active transaction'),
            function () use ($I) {
                $fileName   = $I->getNewFileName('log', 'log');
                $outputPath = logsDir();
                $adapter    = new Stream($outputPath . $fileName);

                $adapter->rollback();
            }
        );
    }
}

<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use Cardoe\Test\Fixtures\Traits\LoggerTrait;
use IntegrationTester;
use function getNewFileName;
use function logsDir;
use function skipTest;

class EnableLoggingCest
{
    use ConnectionTrait;
    use LoggerTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: enableLogging() - without trace
     *
     * @since  2019-11-16
     */
    public function connectionEnableLoggingWithTrace(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - enableLogging() - with trace');

        $fileName = getNewFileName('log', 'log');
        $logger   = $this->getLogger($fileName);

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $this
            ->connection
            ->setLogger($logger)
        ;

        $this
            ->connection
            ->enableLogTrace(true)
            ->enableLogging(true)
        ;

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = ?',
            [
                0 => 1,
            ]
        );
        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);

        $I->amInPath(logsDir());
        $I->seeFileFound($fileName);
        $I->openFile($fileName);
        $I->seeInThisFile('[info]');
        $I->seeInThisFile('[A: ');
        $I->seeInThisFile('[Z: ');
        $I->seeInThisFile('[D: ');
        $I->seeInThisFile('[S: ');
        $I->seeInThisFile('[V: ');
        $I->seeInThisFile('[Trace: ');
    }

    /**
     * Tests Cardoe\DM\Pdo\Connection :: enableLogging() - without trace
     *
     * @since  2019-11-16
     */
    public function connectionEnableLoggingWithoutTrace(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - enableLogging() - without trace');

        $fileName = getNewFileName('log', 'log');
        $logger   = $this->getLogger($fileName);

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $this
            ->connection
            ->setLogger($logger)
        ;

        $this->connection->enableLogging(true);
        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = ?',
            [
                0 => 1,
            ]
        );
        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);

        $I->amInPath(logsDir());
        $I->seeFileFound($fileName);
        $I->openFile($fileName);
        $I->seeInThisFile('[info]');
        $I->seeInThisFile('[A: ');
        $I->seeInThisFile('[Z: ');
        $I->seeInThisFile('[D: ');
        $I->seeInThisFile('[S: ');
        $I->seeInThisFile('[V: ');
        $I->dontSeeInThisFile('[Trace: ');
    }
}

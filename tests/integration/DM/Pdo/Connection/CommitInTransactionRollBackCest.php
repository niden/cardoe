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
use IntegrationTester;
use function date;
use function skipTest;
use function str_replace;
use function uniqid;

class CommitInTransactionRollBackCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: commit()/inTransaction()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionCommitInTransaction(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - commit()/inTransaction()');

        $this
            ->connection
            ->beginTransaction()
        ;

        $I->assertTrue($this->connection->inTransaction());

        $template = 'insert into co_invoices (inv_id, inv_cst_id, inv_status_flag, '
            . 'inv_title, inv_total, inv_created_at) values ('
            . '%id%, 1, 1, "%title%", %total%, "%now%")';

        $sql = str_replace(
            [
                '%id%',
                '%title%',
                '%total%',
                '%now%',
            ],
            [
                2,
                uniqid(),
                102,
                date('Y-m-d H:i:s')
            ],
            $template
        );

        $result = $this->connection->exec($sql);
        $I->assertEquals(1, $result);

        $this->connection->commit();

        /**
         * Committed record
         */
        $all = $this
            ->connection
            ->fetchOne(
                'select * from co_invoices WHERE inv_id = ?',
                [
                    0 => 2,
                ]
            );

        $I->assertIsArray($all);
        $I->assertEquals(2, $all['inv_id']);
    }

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: rollBack()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionRollBack(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - rollBack()');

        $this
            ->connection
            ->beginTransaction()
        ;

        $I->assertTrue($this->connection->inTransaction());

        $template = 'insert into co_invoices (inv_id, inv_cst_id, inv_status_flag, '
            . 'inv_title, inv_total, inv_created_at) values ('
            . '%id%, 1, 1, "%title%", %total%, "%now%")';

        $sql = str_replace(
            [
                '%id%',
                '%title%',
                '%total%',
                '%now%',
            ],
            [
                2,
                uniqid(),
                102,
                date('Y-m-d H:i:s')
            ],
            $template
        );

        $result = $this->connection->exec($sql);
        $I->assertEquals(1, $result);

        /**
         * Committed record
         */
        $all = $this
            ->connection
            ->fetchOne(
                'select * from co_invoices WHERE inv_id = ?',
                [
                    0 => 2,
                ]
            );

        $this->connection->rollBack();

        $all = $this
            ->connection
            ->fetchOne(
                'select * from co_invoices WHERE inv_id = ?',
                [
                    0 => 2,
                ]
            );

        $I->assertIsArray($all);
        $I->assertEmpty($all);
    }
}

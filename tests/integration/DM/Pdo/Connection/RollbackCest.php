<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;
use function date;
use function skipTest;
use function str_replace;
use function uniqid;

class RollbackCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: rollback()
     *
     * @since  2019-11-16
     */
    public function connectionRollback(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - rollback()');


        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $this
            ->connection
            ->beginTransaction()
        ;

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

        $this->connection->rollBack();

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

        $I->assertNull($all);
    }
}

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
use PDO;

class FetchOneCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchOne()
     *
     * @since  2019-11-16
     */
    public function connectionFetchOne(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = ?',
            [
                0 => 1,
            ]
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);
        $I->assertArrayHasKey('inv_id', $all);
        $I->assertArrayHasKey('inv_cst_id', $all);
        $I->assertArrayHasKey('inv_status_flag', $all);
        $I->assertArrayHasKey('inv_title', $all);
        $I->assertArrayHasKey('inv_total', $all);
        $I->assertArrayHasKey('inv_created_at', $all);
    }

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchOne() - no result
     *
     * @since  2019-11-16
     */
    public function connectionFetchOneNoResult(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne() - no result');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = ?',
            [
                0 => 7,
            ]
        );

        $I->assertNull($all);
    }

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchOne() - bind types
     *
     * @since  2019-11-16
     */
    public function connectionFetchOneNoBindTypes(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne() - bind types');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = ?',
            [
                0 => 1,
            ]
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = :id',
            [
                'id' => 1,
            ]
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = :id',
            [
                'id' => [
                    1,
                    PDO::PARAM_STR
                ],
            ]
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = :id',
            [
                'id' => [
                    true,
                    PDO::PARAM_BOOL
                ],
            ]
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);
    }
}

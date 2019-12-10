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
use function skipTest;

class QueryCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: query()
     *
     * @since  2019-11-16
     */
    public function connectionQuery(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - query()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this
            ->connection
            ->query(
            'select * from co_invoices WHERE inv_id = 1'
            )
            ->fetch()
        ;

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);
        $I->assertArrayHasKey('inv_id', $all);
        $I->assertArrayHasKey('inv_cst_id', $all);
        $I->assertArrayHasKey('inv_status_flag', $all);
        $I->assertArrayHasKey('inv_title', $all);
        $I->assertArrayHasKey('inv_total', $all);
        $I->assertArrayHasKey('inv_created_at', $all);
    }
}

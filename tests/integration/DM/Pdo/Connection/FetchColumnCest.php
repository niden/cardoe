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

class FetchColumnCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchColumn()
     *
     * @since  2019-11-16
     */
    public function connectionFetchColumn(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchColumn()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(2);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(3);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(4);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchColumn(
            'SELECT inv_total from co_invoices order by inv_total'
        );
        $I->assertCount(4, $all);

        $expected = [
            0 => 101,
            1 => 102,
            2 => 103,
            3 => 104,
        ];
        $I->assertEquals($expected, $all);
    }
}

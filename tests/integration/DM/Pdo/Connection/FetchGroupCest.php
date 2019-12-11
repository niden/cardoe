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

class FetchGroupCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchGroup()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchGroup(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchGroup()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(2);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(3);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(4);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchGroup(
            'SELECT inv_status_flag, inv_id, inv_total from co_invoices'
        );

        $I->assertEquals(2, $all[0][0]['inv_id']);
        $I->assertEquals(4, $all[0][1]['inv_id']);
        $I->assertEquals(1, $all[1][0]['inv_id']);
        $I->assertEquals(3, $all[1][1]['inv_id']);
    }
}

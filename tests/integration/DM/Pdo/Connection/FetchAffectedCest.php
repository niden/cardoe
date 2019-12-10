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

class FetchAffectedCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchAffected()
     *
     * @since  2019-11-16
     */
    public function connectionFetchAffected(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchAffected()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(2);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(3);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(4);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchAffected(
            'select inv_id, inv_total from co_invoices WHERE inv_cst_id = ?',
            [
                0 => 1,
            ]
        );
        $I->assertEquals(4, $all);
    }
}

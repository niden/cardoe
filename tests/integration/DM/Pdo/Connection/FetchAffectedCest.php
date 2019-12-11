<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Connection;
use IntegrationTester;

class FetchAffectedCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchAffected()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchAffected(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchAffected()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $result = $I->getNewInvoice($connection, 1);
        $I->assertEquals(1, $result);
        $result = $I->getNewInvoice($connection, 2);
        $I->assertEquals(1, $result);
        $result = $I->getNewInvoice($connection, 3);
        $I->assertEquals(1, $result);
        $result = $I->getNewInvoice($connection, 4);
        $I->assertEquals(1, $result);

        $all = $connection->fetchAffected(
            'select inv_id, inv_total from co_invoices WHERE inv_cst_id = ?',
            [
                0 => 1,
            ]
        );
        $I->assertEquals(4, $all);
    }
}

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

class FetchValueCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchValue()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchValue(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchValue()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $result = $I->getNewInvoice($connection, 1);
        $I->assertEquals(1, $result);

        $all = $connection->fetchValue(
            'select inv_total from co_invoices WHERE inv_cst_id = ?',
            [
                0 => 1,
            ]
        );
        $I->assertEquals(101, $all);
    }
}

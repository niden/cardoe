<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Connection;
use IntegrationTester;
use function var_dump;

class FetchColCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchCol()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchCol(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchCol()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $result = $I->getNewInvoice($connection, 1);
        $I->assertEquals(1, $result);
        $result = $I->getNewInvoice($connection, 2);
        $I->assertEquals(1, $result);
        $result = $I->getNewInvoice($connection, 3);
        $I->assertEquals(1, $result);

        $all = $connection->fetchCol(
            'select * from co_invoices'
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all[0]);
        $I->assertEquals(2, $all[1]);
        $I->assertEquals(3, $all[2]);
    }
}

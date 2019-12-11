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

class ExecCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: exec()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionExec(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - exec()');

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

        $all = $connection->exec(
            'update co_invoices set inv_total = inv_total + 100'
        );

        $I->assertEquals(4, $all);
    }
}

<?php

/**
* This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use Phalcon\DM\Pdo\Connection;
use IntegrationTester;

class FetchAffectedCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: fetchAffected()
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
            'delete from co_invoices',
        );
        $I->assertEquals(4, $all);
    }
}

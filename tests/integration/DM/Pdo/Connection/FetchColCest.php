<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;
use function var_dump;

class FetchColCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchCol()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchCol(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchCol()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(2);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(3);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchCol(
            'select * from co_invoices'
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all[0]);
        $I->assertEquals(2, $all[1]);
        $I->assertEquals(3, $all[2]);
    }
}

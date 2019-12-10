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

class FetchKeyPairCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchKeyPair()
     *
     * @since  2019-11-16
     */
    public function connectionFetchKeyPair(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchKeyPair()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(2);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(3);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(4);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchKeyPair(
            'SELECT inv_id, inv_total from co_invoices'
        );
        $I->assertCount(4, $all);

        $expected = [
            1 => 101,
            2 => 102,
            3 => 103,
            4 => 104,
        ];
        $I->assertEquals($expected, $all);
    }
}

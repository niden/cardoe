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

class FetchValueCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchValue()
     *
     * @since  2019-11-16
     */
    public function connectionFetchValue(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchValue()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchValue(
            'select inv_total from co_invoices WHERE inv_cst_id = ?',
            [
                0 => 1,
            ]
        );
        $I->assertEquals(101, $all);
    }
}

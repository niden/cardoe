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

class ExecCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: exec()
     *
     * @since  2019-11-16
     */
    public function connectionExec(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - exec()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(2);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(3);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(4);
        $I->assertEquals(1, $result);

        $all = $this->connection->exec(
            'update co_invoices set inv_total = inv_total + 100'
        );

        $I->assertEquals(4, $all);
    }
}

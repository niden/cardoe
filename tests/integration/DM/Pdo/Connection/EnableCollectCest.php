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

class EnableCollectCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: enableCollect
     *
     * @since  2019-11-16
     */
    public function connectionEnableCollect(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - enableCollect()');

        $this->connection->enableCollect(true);

        $query = 'SELECT * FROM co_invoices WHERE inv_id = :id';
        $data  = $this->connection->fetchAll($query, ['id' => 1]);

        $I->assertEmpty($data);
        $queries = $this->connection->getQueries();

        $I->assertCount(1, $queries);
    }
}

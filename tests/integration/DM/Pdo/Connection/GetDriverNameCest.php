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

class GetDriverNameCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: getDriverName()
     *
     * @since  2019-11-16
     */
    public function connectionGetDriverName(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getDriverName()');

        $driver = $this->connection->getDriverName();
        $I->assertEquals('mysql', $driver);
    }
}

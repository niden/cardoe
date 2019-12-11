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

class GetAdapterCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: getAdapter()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionGetAdapter(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getAdapter()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $I->assertTrue($connection->isConnected());

        $connection->connect();

        $I->assertTrue($connection->isConnected());
        $I->assertNotEmpty($connection->getAdapter());

        $connection->disconnect();

        $I->assertNotEmpty(
            $connection->getAdapter(),
            'getPdo() will re-connect if disconnected'
        );
        $I->assertTrue($connection->isConnected());
    }
}

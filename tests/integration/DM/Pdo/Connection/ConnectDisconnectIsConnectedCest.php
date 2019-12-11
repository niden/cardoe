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

class ConnectDisconnectIsConnectedCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: connect()/disconnect()/isConnected()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionConnectDisconnectIsConnected(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - connect()/disconnect()/isConnected()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $I->assertTrue($connection->isConnected());
        $connection->connect();
        $I->assertTrue($connection->isConnected());
        $connection->disconnect();
        $I->assertFalse($connection->isConnected());
    }
}

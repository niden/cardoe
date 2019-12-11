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

class ConnectDisconnectIsConnectedCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: connect()/disconnect()/isConnected()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionConnectDisconnectIsConnected(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - connect()/disconnect()/isConnected()');

        $I->assertFalse($this->connection->isConnected());
        $this->connection->connect();
        $I->assertTrue($this->connection->isConnected());
        $this->connection->disconnect();
        $I->assertFalse($this->connection->isConnected());
    }
}

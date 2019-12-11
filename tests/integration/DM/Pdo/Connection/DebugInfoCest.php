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
use PDO;

class DebugInfoCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: __debugInfo()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionDebugInfo(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - __debugInfo()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $expected = [
            'args' => [
                $I->getDatabaseDsn(),
                '****',
                '****',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ],
                [],
            ]
        ];
        $I->assertEquals($expected, $connection->__debugInfo());
    }
}

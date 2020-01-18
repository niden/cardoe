<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use IntegrationTester;
use Phalcon\DM\Pdo\Connection;

class ConstructCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: __construct()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionConstruct(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - __construct()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $I->assertInstanceOf(Connection::class, $connection);
    }
}

<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use Phalcon\DM\Pdo\Connection;
use IntegrationTester;
use PDO;

class GetAvailableDriversCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: getAvailableDrivers()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionGetAvailableDrivers(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getAvailableDrivers()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $expected = PDO::getAvailableDrivers();
        $actual   = $connection::getAvailableDrivers();

        $I->assertEquals($expected, $actual);
    }
}

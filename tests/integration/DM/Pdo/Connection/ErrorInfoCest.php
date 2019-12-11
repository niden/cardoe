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

class ErrorInfoCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: errorInfo()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionErrorInfo(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - errorInfo()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $actual = $connection->errorInfo();
        $expect = ['00000', null, null];

        $I->assertEquals($expect, $actual);
    }
}

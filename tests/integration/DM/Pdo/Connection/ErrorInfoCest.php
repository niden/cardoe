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

class ErrorInfoCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: errorInfo()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionErrorInfo(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - errorInfo()');

        $actual = $this->connection->errorInfo();
        $expect = ['', null, null];

        $I->assertEquals($expect, $actual);
    }
}

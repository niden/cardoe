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

class ErrorCodeCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: errorCode()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionErrorCode(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - errorCode()');

        $actual = $this->connection->errorCode();

        $I->assertNull($actual);
    }
}

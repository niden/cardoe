<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;
use PDO;

class GetPdoCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: getPdo()
     *
     * @since  2019-11-16
     */
    public function connectionGetPdo(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getPdo()');

        $pdo = $this->connection->getPdo();
        $I->assertInstanceOf(PDO::class, $pdo);

        $I->assertEquals(
            'mysql',
            $pdo->getAttribute(PDO::ATTR_DRIVER_NAME)
        );
    }
}

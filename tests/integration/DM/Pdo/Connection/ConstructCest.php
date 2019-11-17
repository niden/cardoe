<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Connection;
use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;

class ConstructCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: __construct()
     *
     * @since  2019-11-06
     */
    public function connectionConstruct(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - __construct()');

        $I->assertInstanceOf(Connection::class, $this->connection);
    }
}

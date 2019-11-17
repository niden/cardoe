<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;
use function skipTest;

class EnableLoggingCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: enableLogging()
     *
     * @since  2019-11-16
     */
    public function connectionEnableLogging(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - enableLogging()');
        skipTest('Todo');
    }
}

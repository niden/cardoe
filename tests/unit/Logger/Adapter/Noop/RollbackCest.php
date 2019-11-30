<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Adapter\Noop;

use Cardoe\Logger\Adapter\Noop;
use UnitTester;

class RollbackCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: rollback()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopRollback(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - rollback()');

        $adapter = new Noop();

        $adapter->begin();

        $I->assertTrue(
            $adapter->inTransaction()
        );

        $adapter->rollback();

        $I->assertFalse(
            $adapter->inTransaction()
        );
    }
}

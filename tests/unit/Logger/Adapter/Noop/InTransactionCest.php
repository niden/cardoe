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

class InTransactionCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: inTransaction()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopInTransaction(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - inTransaction()');

        $adapter = new Noop();

        $adapter->begin();

        $I->assertTrue(
            $adapter->inTransaction()
        );

        $adapter->commit();

        $I->assertFalse(
            $adapter->inTransaction()
        );
    }
}

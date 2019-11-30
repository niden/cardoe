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
use Cardoe\Logger\Exception;
use UnitTester;

class CommitCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: commit()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopCommit(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - commit()');

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

    /**
     * Tests Cardoe\Logger\Adapter\Noop :: commit() - no transaction
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopCommitNoTransaction(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - commit() - no transaction');

        $adapter = new Noop();

        $I->assertFalse(
            $adapter->inTransaction()
        );

        $I->expectThrowable(
            new Exception('There is no active transaction'),
            function () use ($adapter) {
                $adapter->commit();
            }
        );
    }
}

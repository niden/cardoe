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

class BeginCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: begin()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopBegin(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - begin()');

        $adapter = new Noop();

        $I->assertFalse(
            $adapter->inTransaction()
        );

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

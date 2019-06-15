<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Adapter\Noop;

use Cardoe\Logger\Adapter\Noop;
use UnitTester;

class CloseCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: close()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopClose(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - close()');

        $adapter = new Noop();

        $I->assertTrue(
            $adapter->close()
        );
    }
}

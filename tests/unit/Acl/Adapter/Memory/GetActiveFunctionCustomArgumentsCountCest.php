<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Adapter\Memory;

use UnitTester;

class GetActiveFunctionCustomArgumentsCountCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory ::
     * getActiveFunctionCustomArgumentsCount()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetActiveFunctionCustomArgumentsCount(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getActiveFunctionCustomArgumentsCount()');

        $I->skipTest('Need implementation');
    }
}

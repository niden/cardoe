<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Str;

use Cardoe\Helper\Str;
use UnitTester;

class IsLowerCest
{
    /**
     * Tests Cardoe\Helper\Str :: isLower()
     *
     * @since  2019-04-06
     */
    public function helperStrIsLower(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - isLower()');

        $actual = Str::isLower('phalcon framework');
        $I->assertTrue($actual);

        $actual = Str::isLower('Cardoe Framework');
        $I->assertFalse($actual);
    }
}

<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Number;

use Cardoe\Helper\Number;
use UnitTester;

class BetweenCest
{
    /**
     * Tests Cardoe\Helper\Number :: between()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-02-17
     */
    public function helperNumberBetween(UnitTester $I)
    {
        $I->wantToTest('Helper\Number - between()');

        $I->assertTrue(
            Number::between(5, 1, 10)
        );

        $I->assertTrue(
            Number::between(1, 1, 10)
        );

        $I->assertTrue(
            Number::between(10, 1, 10)
        );

        $I->assertFalse(
            Number::between(1, 5, 10)
        );
    }
}

<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Arr;

use Cardoe\Helper\Arr;
use UnitTester;

class FlattenCest
{
    /**
     * Tests Cardoe\Helper\Arr :: flatten()
     *
     * @since  2019-04-06
     */
    public function helperArrFlatten(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - flatten()');

        $source = [1, [2], [[3], 4], 5];

        $expected = [1, 2, [3], 4, 5];
        $actual   = Arr::flatten($source);

        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Arr :: flatten() - deep
     *
     * @since  2019-04-06
     */
    public function helperArrFlattenDeep(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - flatten() - deep');

        $source = [1, [2], [[3], 4], 5];

        $expected = [1, 2, 3, 4, 5];
        $actual   = Arr::flatten($source, true);
        $I->assertEquals($expected, $actual);
    }
}

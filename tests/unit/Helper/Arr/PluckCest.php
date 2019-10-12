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

class PluckCest
{
    /**
     * Tests Cardoe\Helper\Arr :: pluck()
     *
     * @since  2019-04-07
     */
    public function helperArrPluck(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - pluck()');
        $collection = [
            ['product_id' => 'prod-100', 'name' => 'Desk'],
            ['product_id' => 'prod-200', 'name' => 'Chair'],
        ];

        $expected = ['Desk', 'Chair'];
        $actual   = Arr::pluck($collection, 'name');
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Arr :: pluck() - object
     *
     * @since  2019-04-07
     */
    public function helperArrPluckObject(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - pluck()');
        $collection = [
            Arr::toObject(['product_id' => 'prod-100', 'name' => 'Desk']),
            Arr::toObject(['product_id' => 'prod-200', 'name' => 'Chair']),
        ];

        $expected = ['Desk', 'Chair'];
        $actual   = Arr::pluck($collection, 'name');
        $I->assertEquals($expected, $actual);
    }
}

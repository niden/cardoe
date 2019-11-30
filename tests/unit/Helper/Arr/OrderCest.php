<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Helper\Arr;

use Cardoe\Helper\Arr;
use UnitTester;

class OrderCest
{
    /**
     * Tests Cardoe\Helper\Arr :: order()
     *
     * @since  2019-04-06
     */
    public function helperArrOrder(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - order()');

        $collection = [
            ['id' => 2, 'name' => 'Paul'],
            ['id' => 3, 'name' => 'Peter'],
            ['id' => 1, 'name' => 'John'],
        ];


        $expected = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Paul'],
            ['id' => 3, 'name' => 'Peter'],
        ];

        $I->assertEquals(
            $expected,
            Arr::order($collection, 'id')
        );


        $expected = [
            ['id' => 3, 'name' => 'Peter'],
            ['id' => 2, 'name' => 'Paul'],
            ['id' => 1, 'name' => 'John'],
        ];

        $I->assertEquals(
            $expected,
            Arr::order($collection, 'id', 'desc')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: order() - object
     *
     * @since  2019-04-06
     */
    public function helperArrOrderObject(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - order()');

        $collection = [
            Arr::toObject(['id' => 2, 'name' => 'Paul']),
            Arr::toObject(['id' => 3, 'name' => 'Peter']),
            Arr::toObject(['id' => 1, 'name' => 'John']),
        ];


        $expected = [
            Arr::toObject(['id' => 1, 'name' => 'John']),
            Arr::toObject(['id' => 2, 'name' => 'Paul']),
            Arr::toObject(['id' => 3, 'name' => 'Peter']),
        ];

        $I->assertEquals(
            $expected,
            Arr::order($collection, 'id')
        );


        $expected = [
            Arr::toObject(['id' => 3, 'name' => 'Peter']),
            Arr::toObject(['id' => 2, 'name' => 'Paul']),
            Arr::toObject(['id' => 1, 'name' => 'John']),
        ];

        $I->assertEquals(
            $expected,
            Arr::order($collection, 'id', 'desc')
        );
    }
}

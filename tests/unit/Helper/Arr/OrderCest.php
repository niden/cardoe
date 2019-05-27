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

class OrderCest
{
    /**
     * Tests Cardoe\Helper\Arr :: order()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperArrOrder(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - order()');

        $collection = [
            ['id' => 2, 'name' => 'Joy'],
            ['id' => 3, 'name' => 'Khaja'],
            ['id' => 1, 'name' => 'Raja'],
        ];


        $expected = [
            ['id' => 1, 'name' => 'Raja'],
            ['id' => 2, 'name' => 'Joy'],
            ['id' => 3, 'name' => 'Khaja'],
        ];

        $I->assertEquals(
            $expected,
            Arr::order($collection, 'id')
        );


        $expected = [
            ['id' => 3, 'name' => 'Khaja'],
            ['id' => 2, 'name' => 'Joy'],
            ['id' => 1, 'name' => 'Raja'],
        ];

        $I->assertEquals(
            $expected,
            Arr::order($collection, 'id', 'desc')
        );
    }
}

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
use stdClass;
use UnitTester;

class GroupCest
{
    /**
     * Tests Cardoe\Helper\Arr :: group()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-07
     */
    public function helperArrGroup(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - group()');

        $collection = [
            ['name' => 'Paul', 'age' => 34],
            ['name' => 'Peter', 'age' => 31],
            ['name' => 'John', 'age' => 29],
        ];

        $expected = [
            34 => [
                [
                    'name' => 'Paul',
                    'age'  => 34,
                ],
            ],
            31 => [
                [
                    'name' => 'Peter',
                    'age'  => 31,
                ],
            ],
            29 => [
                [
                    'name' => 'John',
                    'age'  => 29,
                ],
            ],
        ];

        $actual = Arr::group($collection, 'age');

        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Arr :: group() - object
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-07
     */
    public function helperArrGroupObject(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - group() - object');

        $peter       = new stdClass();
        $peter->name = 'Peter';
        $peter->age  = 34;

        $paul       = new stdClass();
        $paul->name = 'Paul';
        $paul->age  = 31;

        $collection = [
            'peter' => $peter,
            'paul'  => $paul,
        ];


        $expected = [
            'Peter' => [$peter],
            'Paul'  => [$paul],
        ];

        $I->assertEquals(
            $expected,
            Arr::group($collection, 'name')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: group() - function
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-07
     */
    public function helperArrGroupFunction(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - group() - function');

        $collection = ['one', 'two', 'three'];

        $expected = [
            3 => ['one', 'two'],
            5 => ['three'],
        ];

        $I->assertEquals(
            $expected,
            Arr::group($collection, 'strlen')
        );
    }
}

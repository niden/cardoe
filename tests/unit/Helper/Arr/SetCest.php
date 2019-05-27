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

class SetCest
{
    /**
     * Tests Cardoe\Helper\Arr :: set() - numeric
     *
     * @since  2018-11-13
     */
    public function helperArrSetNumeric(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - set() - numeric');

        $collection = [];

        $expected = [
            1 => 'Cardoe',
        ];

        $I->assertEquals(
            $expected,
            Arr::set($collection, 'Cardoe', 1)
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: set() - string
     *
     * @since  2018-11-13
     */
    public function helperArrSetString(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - set() - string');

        $collection = [];

        $expected = [
            'suffix' => 'Framework',
        ];

        $I->assertEquals(
            $expected,
            Arr::set($collection, 'Framework', 'suffix')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: set() - no index
     *
     * @since  2018-11-13
     */
    public function helperArrSetNoIndex(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - set() - no index');

        $collection = [];

        $expected = [
            0 => 'Cardoe',
        ];

        $I->assertEquals(
            $expected,
            Arr::set($collection, 'Cardoe')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: set() - overwrite
     *
     * @since  2018-11-13
     */
    public function helperArrSetOverwride(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - set() - overwrite');

        $collection = [
            1 => 'Cardoe',
        ];

        $expected = [
            1 => 'Framework',
        ];

        $I->assertEquals(
            $expected,
            Arr::set($collection, 'Framework', 1)
        );
    }
}

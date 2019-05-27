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

class FirstKeyCest
{
    /**
     * Tests Cardoe\Helper\Arr :: firstKey()
     *
     * @since  2019-04-07
     */
    public function helperArrFirstKey(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - firstKey()');
        $collection = [
            1 => 'Cardoe',
            3 => 'Framework',
        ];

        $expected = 1;
        $actual   = Arr::firstKey($collection);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Arr :: firstKey() - function
     *
     * @since  2019-04-07
     */
    public function helperArrFirstKeyFunction(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - firstKey() - function');
        $collection = [
            1 => 'Cardoe',
            3 => 'Framework',
        ];

        $expected = 3;
        $actual   = Arr::firstKey(
            $collection,
            function ($element) {
                return strlen($element) > 8;
            }
        );
        $I->assertEquals($expected, $actual);
    }
}

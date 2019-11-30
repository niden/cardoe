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

class LastCest
{
    /**
     * Tests Cardoe\Helper\Arr :: last()
     *
     * @since  2019-04-06
     */
    public function helperArrLast(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - last()');

        $collection = [
            'Cardoe',
            'Framework',
        ];

        $I->assertEquals(
            'Framework',
            Arr::last($collection)
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: last() - function
     *
     * @since  2019-04-06
     */
    public function helperArrLastFunction(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - last() - function');

        $collection = [
            'Cardoe',
            'Framework',
        ];

        $actual = Arr::last(
            $collection,
            function ($element) {
                return strlen($element) < 8;
            }
        );

        $I->assertEquals(
            'Cardoe',
            $actual
        );
    }
}

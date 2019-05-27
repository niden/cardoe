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

class FirstCest
{
    /**
     * Tests Cardoe\Helper\Arr :: first()
     *
     * @since  2019-04-06
     */
    public function helperArrFirst(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - first()');

        $collection = [
            'Cardoe',
            'Framework',
        ];

        $I->assertEquals(
            'Cardoe',
            Arr::first($collection)
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: first() - function
     *
     * @since  2019-04-06
     */
    public function helperArrFirstFunction(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - first() - function');

        $collection = [
            'Cardoe',
            'Framework',
        ];

        $actual = Arr::first(
            $collection,
            function ($element) {
                return strlen($element) > 8;
            }
        );

        $I->assertEquals(
            'Framework',
            $actual
        );
    }
}

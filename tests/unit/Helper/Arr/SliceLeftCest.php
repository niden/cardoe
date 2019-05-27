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

class SliceLeftCest
{
    /**
     * Tests Cardoe\Helper\Arr :: sliceLeft()
     *
     * @since  2019-04-06
     */
    public function helperArrSliceLeft(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - sliceLeft()');

        $collection = [
            'Cardoe',
            'Framework',
            'for',
            'PHP',
        ];


        $expected = [
            'Cardoe',
        ];

        $I->assertEquals(
            $expected,
            Arr::sliceLeft($collection, 1)
        );


        $expected = [
            'Cardoe',
            'Framework',
            'for',
        ];

        $I->assertEquals(
            $expected,
            Arr::sliceLeft($collection, 3)
        );
    }
}

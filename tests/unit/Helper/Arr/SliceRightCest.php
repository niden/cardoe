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

class SliceRightCest
{
    /**
     * Tests Cardoe\Helper\Arr :: sliceRight()
     *
     * @since  2019-04-06
     */
    public function helperArrSliceRight(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - sliceRight()');

        $collection = [
            'Cardoe',
            'Framework',
            'for',
            'PHP',
        ];

        $expected = [
            'Framework',
            'for',
            'PHP',
        ];

        $I->assertEquals(
            $expected,
            Arr::sliceRight($collection, 1)
        );


        $expected = [
            'PHP',
        ];

        $I->assertEquals(
            $expected,
            Arr::sliceRight($collection, 3)
        );
    }
}

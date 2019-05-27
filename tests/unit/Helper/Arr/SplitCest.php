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

class SplitCest
{
    /**
     * Tests Cardoe\Helper\Arr :: split()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-07
     */
    public function helperArrSplit(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - split()');
        $collection = [
            1 => 'Cardoe',
            3 => 'Framework',
        ];

        $expected = [
            [1, 3],
            ['Cardoe', 'Framework'],
        ];
        $actual   = Arr::split($collection);
        $I->assertEquals($expected, $actual);
    }
}

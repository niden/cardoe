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

class HasCest
{
    /**
     * Tests Cardoe\Helper\Arr :: has()
     *
     * @since  2018-11-13
     */
    public function helperArrHas(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - has()');

        $collection = [
            1        => 'Cardoe',
            'suffix' => 'Framework',
        ];

        $I->assertTrue(
            Arr::has($collection, 1)
        );

        $I->assertTrue(
            Arr::has($collection, 'suffix')
        );

        $I->assertFalse(
            Arr::has($collection, 'unknown')
        );
    }
}

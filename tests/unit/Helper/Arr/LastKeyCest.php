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

class LastKeyCest
{
    /**
     * Tests Cardoe\Helper\Arr :: last()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperArrLast(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - last()');

        $collection = [
            1 => 'Cardoe',
            3 => 'Framework',
        ];

        $I->assertEquals(
            3,
            Arr::lastKey($collection)
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: last() - function
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperArrLastFunction(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - last() - function');

        $collection = [
            1 => 'Cardoe',
            3 => 'Framework',
        ];

        $actual = Arr::lastKey(
            $collection,
            function ($element) {
                return strlen($element) < 8;
            }
        );

        $I->assertEquals(
            1,
            $actual
        );
    }
}

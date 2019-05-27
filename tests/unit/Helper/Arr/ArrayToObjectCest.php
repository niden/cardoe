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

class ArrayToObjectCest
{
    /**
     * Unit Tests Cardoe\Helper\Arr :: arrayToObject()
     *
     * @since  2019-05-25
     */
    public function helperArrArrayToObject(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - arrayToObject()');

        $source = [
            'one'   => 'two',
            'three' => 'four',
        ];

        $actual = Arr::arrayToObject($source);

        $expected        = new stdClass();
        $expected->one   = 'two';
        $expected->three = 'four';

        $I->assertEquals($expected, $actual);
    }
}

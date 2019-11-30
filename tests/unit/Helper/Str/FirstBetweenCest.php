<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Helper\Str;

use Cardoe\Helper\Str;
use UnitTester;

class FirstBetweenCest
{
    /**
     * Tests Cardoe\Helper\Str :: firstBetween()
     *
     * @since  2019-04-06
     */
    public function helperStrFirstBetween(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - firstBetween()');

        $source   = 'This is a [custom] string';
        $expected = 'custom';
        $actual   = Str::firstBetween($source, '[', ']');
        $I->assertEquals($expected, $actual);
    }
}

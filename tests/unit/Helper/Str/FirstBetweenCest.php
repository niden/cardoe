<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Str;

use Cardoe\Helper\Str;
use UnitTester;

class FirstBetweenCest
{
    /**
     * Tests Cardoe\Helper\Str :: firstBetween()
     *
     * @author Cardoe Team <team@phalconphp.com>
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

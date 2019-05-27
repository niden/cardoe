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

class UnderscoreCest
{
    /**
     * Tests Cardoe\Helper\Str :: underscore()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrUnderscore(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - underscore()');
        $expected = 'start_a_horse';
        $actual   = Str::underscore('start a horse');
        $I->assertEquals($expected, $actual);

        $expected = 'five_cats';
        $actual   = Str::underscore("five\tcats");
        $I->assertEquals($expected, $actual);

        $expected = 'look_behind';
        $actual   = Str::underscore(' look behind ');
        $I->assertEquals($expected, $actual);

        $expected = 'Awesome_Cardoe';
        $actual   = Str::underscore(" \t Awesome \t  \t Cardoe ");
        $I->assertEquals($expected, $actual);
    }
}

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

class HumanizeCest
{
    /**
     * Tests Cardoe\Helper\Str :: humanize()
     *
     * @since  2019-04-06
     */
    public function helperStrHumanize(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - humanize()');
        $expected = 'start a horse';
        $actual   = Str::humanize('start_a_horse');
        $I->assertEquals($expected, $actual);

        $expected = 'five cats';
        $actual   = Str::humanize('five-cats');
        $I->assertEquals($expected, $actual);

        $expected = 'kittens are cats';
        $actual   = Str::humanize('kittens-are_cats');
        $I->assertEquals($expected, $actual);

        $expected = 'Awesome Cardoe';
        $actual   = Str::humanize(" \t Awesome-Cardoe \t ");
        $I->assertEquals($expected, $actual);
    }
}

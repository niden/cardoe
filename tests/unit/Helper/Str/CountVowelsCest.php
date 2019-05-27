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

class CountVowelsCest
{
    /**
     * Tests Cardoe\Helper\Str :: countVowels()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrCountVowels(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - countVowels()');

        $source   = 'Luke, I am your father!';
        $expected = 8;
        $actual   = Str::countVowels($source);
        $I->assertEquals($expected, $actual);

        $source   = '';
        $expected = 0;
        $actual   = Str::countVowels($source);
        $I->assertEquals($expected, $actual);
    }
}

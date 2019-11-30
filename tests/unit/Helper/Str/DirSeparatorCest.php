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

class DirSeparatorCest
{
    /**
     * Tests Cardoe\Helper\Str :: dirSeparator()
     *
     * @since  2019-04-16
     */
    public function helperStrFolderSeparator(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - dirSeparator()');

        $expected = '/home/cardoe/';
        $actual   = Str::dirSeparator('/home/cardoe');
        $I->assertEquals($expected, $actual);

        $expected = '/home/cardoe/';
        $actual   = Str::dirSeparator('/home/cardoe//');
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: dirSeparator() - empty string
     */
    public function helperStrFolderSeparatorEmptyString(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - dirSeparator() - empty string');
        $fileName = '';

        $expected = '/';
        $actual   = Str::dirSeparator($fileName);
        $I->assertEquals($expected, $actual);
    }
}

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

class DirFromFileCest
{
    /**
     * Tests Cardoe\Helper\Str :: dirFromFile()
     *
     * @since  2019-04-16
     */
    public function helperStrFolderFromFile(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - dirFromFile()');
        $fileName = 'abcdef12345.jpg';

        $expected = 'ab/cd/ef/12/3/';
        $actual   = Str::dirFromFile($fileName);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: dirFromFile() - empty string
     */
    public function helperStrFolderFromFileEmptyString(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - dirFromFile() - empty string');
        $fileName = '';

        $expected = '/';
        $actual   = Str::dirFromFile($fileName);
        $I->assertEquals($expected, $actual);
    }
}

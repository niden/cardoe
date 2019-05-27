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

class IncrementCest
{
    /**
     * Tests Cardoe\Helper\Str :: increment() - string
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrIncrementSimpleString(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - increment() - string');
        $source   = 'file';
        $expected = 'file_1';
        $actual   = Str::increment($source);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: increment() - already incremented string
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrIncrementAlreadyIncremented(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - increment() - already incremented string');
        $source   = 'file_1';
        $expected = 'file_2';
        $actual   = Str::increment($source);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: increment() - already incremented string
     * twice
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrIncrementAlreadyIncrementedTwice(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - increment() - already incremented string twice');
        $source   = 'file_2';
        $expected = 'file_3';
        $actual   = Str::increment($source);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: increment() - string with underscore
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrIncrementStringWithUnderscore(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - increment() - string with underscore');
        $source   = 'file_';
        $expected = 'file_1';
        $actual   = Str::increment($source);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: increment() - string with a space at the end
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrIncrementStringWithSpace(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - increment() - string with a space at the end');
        $source   = 'file ';
        $expected = 'file _1';
        $actual   = Str::increment($source);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: increment() - different separator
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrIncrementStringWithDifferentSeparator(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - increment() - string with different separator');
        $source   = 'file';
        $expected = 'file-1';
        $actual   = Str::increment($source, '-');
        $I->assertEquals($expected, $actual);
    }
}

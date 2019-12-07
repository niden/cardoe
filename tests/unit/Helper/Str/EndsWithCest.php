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

class EndsWithCest
{
    /**
     * Tests Cardoe\Helper\Str :: endsWith()
     *
     * @since  2019-04-06
     */
    public function helperStrEndsWith(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - endsWith()');
        $actual = Str::endsWith('Hello', 'o');
        $I->assertTrue($actual);

        $actual = Str::endsWith('Hello', 'lo');
        $I->assertTrue($actual);

        $actual = Str::endsWith('Hello', 'Hello');
        $I->assertTrue($actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: endsWith() - empty strings
     *
     * @since  2019-04-06
     */
    public function helperStrEndsWithEmpty(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - endsWith() - empty strings');
        $actual = Str::endsWith('', '');
        $I->assertFalse($actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: endsWith() - finding an empty string
     *
     * @since  2019-04-06
     */
    public function helperStrEndsWithEmptySearchString(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - endsWith() - search empty string');
        $actual = Str::endsWith('', 'hello');
        $I->assertFalse($actual);
    }


    /**
     * Tests Cardoe\Helper\Str :: endsWith() - case insensitive flag
     *
     * @since  2019-04-06
     */
    public function helperStrEndsWithCaseInsensitive(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - endsWith() - case insensitive flag');
        $actual = Str::endsWith('Hello', 'O');
        $I->assertTrue($actual);

        $actual = Str::endsWith('Hello', 'LO');
        $I->assertTrue($actual);

        $actual = Str::endsWith('Hello', 'hello');
        $I->assertTrue($actual);
    }

    /**
     * Tests Cardoe\Helper\Str :: endsWith() - case sensitive flag
     *
     * @since  2019-04-06
     */
    public function helperStrEndsWithCaseSensitive(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - endsWith() - case sensitive flag');
        $actual = Str::endsWith('Hello', 'hello', true);
        $I->assertTrue($actual);

        $actual = Str::endsWith('Hello', 'hello', false);
        $I->assertFalse($actual);

        $actual = Str::endsWith('Hello', 'O', false);
        $I->assertFalse($actual);
    }
}

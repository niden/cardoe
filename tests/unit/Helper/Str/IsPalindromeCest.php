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

class IsPalindromeCest
{
    /**
     * Tests Cardoe\Helper\Str :: isPalindrome()
     *
     * @since  2019-04-06
     */
    public function helperStrIsPalindrome(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - isPalindrome()');

        $actual = Str::isPalindrome('racecar');
        $I->assertTrue($actual);
    }
}

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

class IsAnagramCest
{
    /**
     * Tests Cardoe\Helper\Str :: isAnagram()
     *
     * @since  2019-04-06
     */
    public function helperStrIsAnagram(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - isAnagram()');

        $actual = Str::isAnagram('rail safety', 'fairy tales');
        $I->assertTrue($actual);
    }
}

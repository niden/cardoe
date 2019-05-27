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

class IsUpperCest
{
    /**
     * Tests Cardoe\Helper\Str :: isUpper()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrIsUpper(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - isUpper()');

        $actual = Str::isUpper('PHALCON FRAMEWORK');
        $I->assertTrue($actual);

        $actual = Str::isUpper('Cardoe Framework');
        $I->assertFalse($actual);
    }
}

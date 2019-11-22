<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Cookies\Cookie;

use Cardoe\Http\Cookies\Cookie;
use UnitTester;

class WithValueCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: withValue()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithValue(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - withValue()');

        $cookie = new Cookie('one');
        $clone  = $cookie
            ->withValue('Darth Vader');

        $I->assertNull($cookie->getValue());
        $I->assertEquals(
            'Darth Vader',
            $clone->getValue()
        );
    }
}

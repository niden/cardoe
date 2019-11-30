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
use DateTime;
use UnitTester;

class RememberForeverCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: rememberForever()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieRememberForever(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - rememberForever()');

        $cookie = new Cookie(
            [
                'Name' => 'one',
            ]
        );

        $past    = (new DateTime('+5 years'))->getTimestamp();
        $clone   = $cookie->rememberForever();
        $expires = $clone->getExpires();

        $min = $past - 10;
        $max = $past + 10;

        $I->assertGreaterOrEquals($min, $expires);
        $I->assertLessOrEquals($max, $expires);
    }
}




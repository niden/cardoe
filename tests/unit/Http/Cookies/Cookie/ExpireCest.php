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

class ExpireCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: expire()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieExpire(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - expire()');

        $cookie = new Cookie('one');
        $cookie->expire();

        $past    = (new DateTime('-5 years'))->getTimestamp();
        $expired = $cookie->getExpires();

        $min = $past - 10;
        $max = $past + 10;

        $I->assertGreaterOrEquals($min, $expired);
        $I->assertLessOrEquals($max, $expired);
    }
}

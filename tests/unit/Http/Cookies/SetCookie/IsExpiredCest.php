<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Cookies\SetCookie;

use Cardoe\Http\Cookies\SetCookie;
use DateTime;
use UnitTester;

class IsExpiredCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: isExpired()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieIsExpired(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - isExpired()');

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertFalse($cookie->isExpired());

        $cookie->setExpires((new DateTime('2019-12-25 01:02:03'))->getTimestamp());
        $I->assertFalse($cookie->isExpired());

        $cookie->setExpires((new DateTime('-1 day'))->getTimestamp());
        $I->assertTrue($cookie->isExpired());
    }
}

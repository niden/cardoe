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
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: __construct()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - __construct()');

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertNull($cookie->getDomain());
        $I->assertFalse($cookie->getHttpOnly());
        $I->assertEquals(0, $cookie->getExpires());
        $I->assertEquals(0, $cookie->getMaxAge());
        $I->assertEquals('one', $cookie->getName());
        $I->assertEmpty($cookie->getPath());
        $I->assertFalse($cookie->getSecure());
        $I->assertNull($cookie->getValue());
    }

    /**
     * Tests Cardoe\Http\Cookies\Cookie :: __construct() - expires
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieConstructExpires(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - __construct() - expires');

        $now    = time();
        $cookie = new SetCookie(
            [
                'Name'    => 'one',
                'Max-Age' => 10,
            ]
        );

        $expected = $now + 10;
        $I->assertEquals($expected, $cookie->getExpires());
    }
}

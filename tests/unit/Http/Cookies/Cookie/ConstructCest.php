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

        $cookie = new Cookie('one');

        $I->assertNull($cookie->getDomain());
        $I->assertFalse($cookie->getHttpOnly());
        $I->assertEquals(0, $cookie->getExpires());
        $I->assertEquals(0, $cookie->getMaxAge());
        $I->assertEquals('one', $cookie->getName());
        $I->assertNull($cookie->getPath());
        $I->assertFalse($cookie->getSecure());
        $I->assertNull($cookie->getValue());
    }
}

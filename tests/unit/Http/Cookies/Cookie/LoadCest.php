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
use InvalidArgumentException;
use UnitTester;

class LoadCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: load()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieLoad(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - load()');

        $cookie = new Cookie('one');

        $I->assertNull($cookie->getDomain());
        $I->assertFalse($cookie->getHttpOnly());
        $I->assertEquals(0, $cookie->getExpires());
        $I->assertEquals(0, $cookie->getMaxAge());
        $I->assertEquals('one', $cookie->getName());
        $I->assertNull($cookie->getPath());
        $I->assertFalse($cookie->getSecure());
        $I->assertNull($cookie->getValue());

        $string = "darth=vader; "
                . "domain=dev.phalcon.ld; "
                . "path=/a/b/c; "
                . "expires=2019-12-25 01:02:03; "
                . "max-age=50; "
                . "httpOnly; "
                . "secure"
        ;

        $clone = $cookie->load($string);
        $expires = (new DateTime('2019-12-25 01:02:03'))->getTimestamp();
        $I->assertEquals('dev.phalcon.ld', $clone->getDomain());
        $I->assertTrue($clone->getHttpOnly());
        $I->assertEquals($expires, $clone->getExpires());
        $I->assertEquals(50, $clone->getMaxAge());
        $I->assertEquals('darth', $clone->getName());
        $I->assertEquals('/a/b/c', $clone->getPath());
        $I->assertTrue($clone->getSecure());
        $I->assertEquals('vader', $clone->getValue());
    }

    /**
     * Tests Cardoe\Http\Cookies\Cookie :: load() - exception
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieLoadException(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - load() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                "The provided cookie string '' must have at least one attribute"
            ),
            function () {
                $cookie = new Cookie('one');
                $clone  = $cookie->load('');
            }
        );
    }
}

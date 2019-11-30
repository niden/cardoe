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

        $string = "darth=vader; "
            . "domain=.phalcon.ld; "
            . "path=/a/b/c; "
            . "expires=2019-12-25 01:02:03; "
            . "max-age=50; "
            . "discard; "
            . "httpOnly; "
            . "secure";

        $cookie->load($string, 'http://phalcon.io');
        $expires = (new DateTime('2019-12-25 01:02:03'))->getTimestamp();

        $I->assertEquals('.phalcon.ld', $cookie->getDomain());
        $I->assertTrue($cookie->getDiscard());
        $I->assertTrue($cookie->getHttpOnly());
        $I->assertEquals($expires, $cookie->getExpires());
        $I->assertEquals(50, $cookie->getMaxAge());
        $I->assertEquals('darth', $cookie->getName());
        $I->assertEquals('/a/b/c', $cookie->getPath());
        $I->assertTrue($cookie->getSecure());
        $I->assertEquals('vader', $cookie->getValue());
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
                $cookie = new SetCookie(
                    [
                        'Name' => 'one',
                    ]
                );

                $clone = $cookie->load('', 'phalcon.ld');
            }
        );
    }
}

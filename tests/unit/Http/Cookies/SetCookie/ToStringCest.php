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

class ToStringCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: __toString()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieToString(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - __toString()');

        $cookie = new Cookie(
            [
                'Name' => 'one',
            ]
        );

        $expected = 'one=';
        $I->assertEquals($expected, $cookie->__toString());

        $cookie->setValue('two');
        $expected = 'one=two';
        $I->assertEquals($expected, $cookie->__toString());

        $cookie->setDomain('phalcon.ld');
        $expected = 'one=two; Domain=.phalcon.ld';
        $I->assertEquals($expected, $cookie->__toString());

        $cookie->setPath('/accounting');
        $expected = 'one=two; Domain=.phalcon.ld; Path=/accounting';
        $I->assertEquals($expected, $cookie->__toString());

        $cookie->setExpires(new DateTime('2019-12-25 01:02:03'));
        $expected = 'one=two; Domain=.phalcon.ld; '
            . 'Expires=Wed, 25 Dec 2019 01:02:03 GMT; Path=/accounting';
        $I->assertEquals($expected, $cookie->__toString());


        $cookie->setMaxAge(50);
        $expected = 'one=two; Domain=.phalcon.ld; '
            . 'Expires=Wed, 25 Dec 2019 01:02:03 GMT; Max-Age=50; Path=/accounting';
        $I->assertEquals($expected, $cookie->__toString());

        $cookie->setHttpOnly(true);
        $expected = 'one=two; Domain=.phalcon.ld; '
            . 'Expires=Wed, 25 Dec 2019 01:02:03 GMT; HttpOnly; '
            . 'Max-Age=50; Path=/accounting';
        $I->assertEquals($expected, $cookie->__toString());

        $cookie->setHttpOnly(false);
        $expected = 'one=two; Domain=.phalcon.ld; '
            . 'Expires=Wed, 25 Dec 2019 01:02:03 GMT; Max-Age=50; Path=/accounting';
        $I->assertEquals($expected, $cookie->__toString());

        $cookie
            ->setHttpOnly(true)
            ->setSecure(true)
        ;
        $expected = 'one=two; Domain=.phalcon.ld; '
            . 'Expires=Wed, 25 Dec 2019 01:02:03 GMT; HttpOnly; '
            . 'Max-Age=50; Path=/accounting; Secure';
        $I->assertEquals($expected, $cookie->__toString());

        $cookie
            ->setHttpOnly(false)
            ->setSecure(true)
        ;
        $expected = 'one=two; Domain=.phalcon.ld; '
            . 'Expires=Wed, 25 Dec 2019 01:02:03 GMT; '
            . 'Max-Age=50; Path=/accounting; Secure';
        $I->assertEquals($expected, $cookie->__toString());
    }
}

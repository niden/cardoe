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

class WithHttpOnlyCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: withHttpOnly()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithHttpOnly(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - withHttpOnly()');

        $cookie = new Cookie('one');
        $clone  = $cookie
            ->withHttpOnly(true);

        $I->assertFalse($cookie->getHttpOnly());
        $I->assertTrue($clone->getHttpOnly());
    }
}

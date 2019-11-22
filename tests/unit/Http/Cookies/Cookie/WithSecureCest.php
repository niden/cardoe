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

class WithSecureCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: withSecure()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithSecure(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - withSecure()');

        $cookie = new Cookie('one');
        $clone  = $cookie
            ->withSecure(true);

        $I->assertFalse($cookie->getSecure());
        $I->assertTrue($clone->getSecure());
    }
}

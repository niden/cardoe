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

class GetSetHttpOnlyCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getHttpOnly()/setHttpOnly()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetHttpOnly(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getHttpOnly()/setHttpOnly()');

        $cookie = new Cookie('one');

        $I->assertFalse($cookie->getHttpOnly());

        $cookie->setHttpOnly(true);
        $I->assertTrue($cookie->getHttpOnly());
    }
}

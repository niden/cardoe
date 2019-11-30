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

class GetSetSecureCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getSecure()/setSecure()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetSecure(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getSecure()/setSecure()');

        $cookie = new Cookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertFalse($cookie->getSecure());

        $cookie->setSecure(true);
        $I->assertTrue($cookie->getSecure());
    }
}

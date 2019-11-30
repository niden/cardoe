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

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertFalse($cookie->getSecure());

        $cookie->setSecure(true);
        $I->assertTrue($cookie->getSecure());
    }
}

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

class GetSetMaxAgeCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getMaxAge()/setMaxAge()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetMaxAge(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getMaxAge()/setMaxAge()');

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertEquals(0, $cookie->getMaxAge());

        $cookie->setMaxAge(1776);
        $I->assertEquals(1776, $cookie->getMaxAge());
    }
}

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

class WithMaxAgeCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: withMaxAge()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithMaxAge(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - withMaxAge()');

        $cookie = new Cookie('one');
        $clone  = $cookie
            ->withMaxAge(1776);

        $I->assertEquals(0, $cookie->getMaxAge());
        $I->assertEquals(
            1776,
            $clone->getMaxAge()
        );
    }
}

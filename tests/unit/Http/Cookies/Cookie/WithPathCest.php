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

class WithPathCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: withPath()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithPath(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - withPath()');

        $cookie = new Cookie('one');
        $clone  = $cookie
            ->withPath('/a/b/c');

        $I->assertNull($cookie->getPath());
        $I->assertEquals(
            '/a/b/c',
            $clone->getPath()
        );
    }
}

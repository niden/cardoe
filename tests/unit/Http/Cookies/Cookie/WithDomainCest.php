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

class WithDomainCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: withDomain()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithDomain(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - withDomain()');

        $cookie = new Cookie('one');
        $clone  = $cookie
            ->withDomain('https://dev.cardoe.ld');

        $I->assertNull($cookie->getDomain());
        $I->assertEquals(
            'https://dev.cardoe.ld',
            $clone->getDomain()
        );
    }
}

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

class GetSetDomainCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getDomain()/setDomain()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetDomain(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getDomain()/setDomain()');

        $cookie = new Cookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertNull($cookie->getDomain());

        $cookie->setDomain('.phalcon.io');
        $I->assertEquals('.phalcon.io', $cookie->getDomain());

        $cookie->setDomain('phalcon.io');
        $I->assertEquals('.phalcon.io', $cookie->getDomain());
    }
}

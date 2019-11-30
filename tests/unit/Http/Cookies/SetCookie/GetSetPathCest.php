<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Cookies\SetCookie;

use Cardoe\Http\Cookies\SetCookie;
use UnitTester;

class GetSetPathCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getPath()/setPath()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetPath(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getPath()/setPath()');

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertEmpty($cookie->getPath());

        $cookie->setPath('/a/b/c');
        $I->assertEquals('/a/b/c', $cookie->getPath());
    }
}

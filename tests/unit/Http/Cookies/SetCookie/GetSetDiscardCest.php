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

class GetSetDiscardCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getDiscard()/setDiscard()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetDiscard(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getDiscard()/setDiscard()');

        $cookie = new Cookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertFalse($cookie->getDiscard());

        $cookie->setDiscard(true);
        $I->assertTrue($cookie->getDiscard());
    }
}

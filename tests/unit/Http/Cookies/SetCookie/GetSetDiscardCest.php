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

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertFalse($cookie->getDiscard());

        $cookie->setDiscard(true);
        $I->assertTrue($cookie->getDiscard());
    }
}

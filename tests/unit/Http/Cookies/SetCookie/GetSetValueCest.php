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

class GetSetValueCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getValue()/setValue()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetValue(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getValue()/setValue()');

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertNull($cookie->getValue());

        $cookie = new SetCookie(
            [
                'Name'  => 'one',
                'Value' => 'two',
            ]
        );

        $I->assertEquals('two', $cookie->getValue());

        $cookie->setValue('four');
        $I->assertEquals('four', $cookie->getValue());
    }
}

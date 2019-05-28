<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Uri;

use Cardoe\Http\Message\Uri;
use UnitTester;

class GetUserInfoCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: getUserInfo()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriGetUserInfo(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - getUserInfo()');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = 'cardoe:secret';
        $actual   = $uri->getUserInfo();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: getUserInfo() - only user
     *
     * @since  2019-02-07
     */
    public function httpUriGetUserInfoOnlyUser(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getUserInfo() - only user');
        $query = 'https://cardoe@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = 'cardoe';
        $actual   = $uri->getUserInfo();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: getUserInfo() - only pass
     *
     * @since  2019-02-07
     */
    public function httpUriGetUserInfoOnlyPass(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getUserInfo() - only pass');
        $query = 'https://:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = ':secret';
        $actual   = $uri->getUserInfo();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: getUserInfo() - empty
     *
     * @since  2019-02-07
     */
    public function httpUriGetUserInfoEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getUserInfo() - empty');
        $query = 'https://dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $actual = $uri->getUserInfo();
        $I->assertEmpty($actual);
    }
}

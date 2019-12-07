<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class GetCookieParamsCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getCookieParams()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetCookieParams(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getCookieParams()');
        $cookies = ['one' => 'two'];
        $request = new ServerRequest('GET', null, [], 'php://input', [], $cookies);

        $expected = $cookies;
        $actual   = $request->getCookieParams();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getCookieParams() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetCookieParamsEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getCookieParams() - empty');
        $request = new ServerRequest();

        $actual = $request->getCookieParams();
        $I->assertEmpty($actual);
    }
}

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

class WithCookieParamsCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withCookieParams()
     *
     * @since  2019-03-03
     */
    public function httpMessageServerRequestWithCookieParams(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withCookieParams()');

        $request = new ServerRequest();

        $newInstance = $request->withCookieParams(
            [
                'one' => 'two',
            ]
        );

        $I->assertNotEquals($request, $newInstance);

        $I->assertEquals(
            [
                'one' => 'two',
            ],
            $newInstance->getCookieParams()
        );
    }
}

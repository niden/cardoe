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

class WithoutHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withoutHeader()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithoutHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withoutHeader()');
        $data        = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $request     = new ServerRequest('GET', null, [], 'php://input', $data);
        $newInstance = $request->withoutHeader('Accept');

        $I->assertNotEquals($request, $newInstance);

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $request->getHeaders();
        $I->assertEquals($expected, $actual);

        $expected = [
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $newInstance->getHeaders();
        $I->assertEquals($expected, $actual);
    }
}

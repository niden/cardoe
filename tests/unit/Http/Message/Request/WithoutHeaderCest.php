<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Request;
use UnitTester;

class WithoutHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: withoutHeader()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithoutHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withoutHeader()');

        $data = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];

        $request = new Request('GET', null, 'php://memory', $data);

        $newInstance = $request->withoutHeader('Accept');

        $I->assertNotEquals($request, $newInstance);

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];

        $I->assertEquals(
            $expected,
            $request->getHeaders()
        );

        $expected = [
            'Cache-Control' => ['max-age=0'],
        ];

        $I->assertEquals(
            $expected,
            $newInstance->getHeaders()
        );
    }
}

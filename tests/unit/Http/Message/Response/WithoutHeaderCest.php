<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Response;

use Cardoe\Http\Message\Response;
use UnitTester;

class WithoutHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: withoutHeader()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseWithoutHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - withoutHeader()');
        $data        = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $response     = new Response('php://memory', 200, $data);
        $newInstance = $response->withoutHeader('Accept');

        $I->assertNotEquals($response, $newInstance);

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $response->getHeaders();
        $I->assertEquals($expected, $actual);

        $expected = [
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $newInstance->getHeaders();
        $I->assertEquals($expected, $actual);
    }
}

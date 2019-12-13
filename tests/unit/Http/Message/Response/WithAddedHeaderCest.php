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

class WithAddedHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: withAddedHeader()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseWithAddedHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - withAddedHeader()');
        $data        = [
            'Accept' => ['text/html'],
        ];
        $response    = new Response('php://memory', 200, $data);
        $newInstance = $response->withAddedHeader('Cache-Control', ['max-age=0']);

        $I->assertNotEquals($response, $newInstance);

        $expected = [
            'Accept' => ['text/html'],
        ];
        $actual   = $response->getHeaders();
        $I->assertEquals($expected, $actual);

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $newInstance->getHeaders();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Response :: withAddedHeader() - merge
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseWithAddedHeaderMerge(UnitTester $I)
    {
        $data        = [
            'Accept' => ['text/html'],
        ];
        $response    = new Response('php://memory', 200, $data);
        $newInstance = $response->withAddedHeader('Accept', ['text/json']);

        $I->assertNotEquals($response, $newInstance);

        $expected = [
            'Accept' => ['text/html'],
        ];
        $actual   = $response->getHeaders();
        $I->assertEquals($expected, $actual);

        $expected = [
            'Accept' => ['text/html', 'text/json'],
        ];
        $actual   = $newInstance->getHeaders();
        $I->assertEquals($expected, $actual);
    }
}

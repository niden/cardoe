<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Response;

use Cardoe\Http\Message\Response;
use UnitTester;

class WithHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: withHeader()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseWithHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - withHeader()');
        $data        = [
            'Accept' => ['text/html'],
        ];
        $response    = new Response('php://memory', 200, $data);
        $newInstance = $response->withHeader('Cache-Control', ['max-age=0']);

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
}

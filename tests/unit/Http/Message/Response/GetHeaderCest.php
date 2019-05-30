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

class GetHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: getHeader() - empty headers
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getHeader()');

        $data = [
            'Cache-Control' => ['max-age=0'],
            'Accept'        => ['text/html'],
        ];

        $response = new Response('php://memory', 200, $data);

        $expected = ['text/html'];

        $I->assertEquals(
            $expected,
            $response->getHeader('accept')
        );


        $I->assertEquals(
            $expected,
            $response->getHeader('aCCepT')
        );
    }

    /**
     * Tests Cardoe\Http\Message\Response :: getHeader() - empty headers
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetHeaderEmptyHeaders(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getHeader() - empty headers');

        $response = new Response();

        $I->assertEquals(
            [],
            $response->getHeader('empty')
        );
    }
}

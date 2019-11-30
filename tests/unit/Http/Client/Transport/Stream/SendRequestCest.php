<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Client\Transport\Stream;

use Cardoe\Http\Client\Transport\Stream;
use Cardoe\Http\Message\Request;
use Cardoe\Http\Message\ResponseFactory;
use Cardoe\Http\Message\StreamFactory;
use Cardoe\Http\Message\Uri;
use UnitTester;

class SendRequestCest
{
    /**
     * Tests Cardoe\Http\Client\Transport\Stream :: sendRequest()
     *
     * @since  2019-11-21
     */
    public function httpClientTransportStreamSendRequest(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Transport\Stream - sendRequest()');


        $responseFactory = new ResponseFactory();
        $streamFactory   = new StreamFactory();
        $transport       = new Stream($streamFactory, $responseFactory);

        $request = new Request(
            'GET',
            new Uri('https://example.com/'),
            'php://temp',
            [
                'Accept-Encoding' => 'text/html',
            ]
        );

        $response = $transport->sendRequest($request);

        $I->assertEquals(
            200,
            $response->getStatusCode()
        );
        $I->assertEquals(
            [
                'text/html; charset=UTF-8',
            ],
            $response->getHeader('Content-type')
        );
        $I->assertContains(
            'Example Domain',
            $response->getBody()->getContents()
        );
    }
}

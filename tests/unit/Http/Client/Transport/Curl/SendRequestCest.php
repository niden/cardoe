<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Client\Transport\Curl;

use Cardoe\Http\Client\Exception\NetworkException;
use Cardoe\Http\Client\MiddlewareInterface;
use Cardoe\Http\Client\Transport\Curl;
use Cardoe\Http\Client\Transport\TransportInterface;
use Cardoe\Http\Message\Request;
use Cardoe\Http\Message\ResponseFactory;
use Cardoe\Http\Message\StreamFactory;
use Cardoe\Http\Message\Uri;
use UnitTester;

class SendRequestCest
{
    /**
     * Tests Cardoe\Http\Client\Transport\Curl :: sendRequest()
     *
     * @since  2019-10-06
     */
    public function httpMessageClientTransportCurlSendRequest(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Client\Transport\Curl - sendRequest()');

        $stream    = new StreamFactory();
        $response  = new ResponseFactory();
        $transport = new Curl($stream, $response);

        $uri = new Uri('https://example.org');
        $request = new Request('GET', $uri);
        $request = $request
            ->withHeader('Accept-Encoding', 'text/html');

        $response = $transport->sendRequest($request);

        $I->assertEquals(200, $response->getStatusCode());
        $I->assertEquals(
            [
                'text/html; charset=UTF-8'
            ],
            $response->getHeader('Content-type')
        );
        $I->assertContains(
            'Example Domain',
            $response->getBody()->getContents()
        );
    }

    /**
     * Tests Cardoe\Http\Client\Transport\Curl :: sendRequest() - exception
     *
     * @since  2019-10-06
     */
    public function httpMessageClientTransportCurlSendRequestException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Client\Transport\Curl - sendRequest() - exception');

        $stream    = new StreamFactory();
        $response  = new ResponseFactory();
        $transport = new Curl($stream, $response);
        $message   = "Could not resolve host: unreachable.address.domain";
        $uri       = new Uri('https://unreachable.address.domain');
        $request   = new Request('GET', $uri);

        $I->expectThrowable(
            new NetworkException($message, $request),
            function () use ($request, $transport) {
                $request = $request
                    ->withHeader('Accept-Encoding', 'text/html');

                $response = $transport->sendRequest($request);
            }
        );
    }
}

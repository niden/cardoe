<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Client\Client;

use Cardoe\Http\Client\Client;
use Cardoe\Http\Client\Transport\Stream;
use Cardoe\Http\Message\Request;
use Cardoe\Http\Message\ResponseFactory;
use Cardoe\Http\Message\StreamFactory;
use Cardoe\Http\Message\Uri;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use UnitTester;
use function var_dump;

class SendRequestCest
{
    /**
     * Tests Cardoe\Http\Client\Client :: sendRequest()
     *
     * @since  2019-11-21
     *
     * @param UnitTester $I
     *
     * @throws ClientExceptionInterface
     */
    public function httpClientClientSendRequest(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Client - sendRequest()');

        $responseFactory = new ResponseFactory();
        $streamFactory   = new StreamFactory();
        $client          = new Client(
            [
                new Stream($streamFactory, $responseFactory),
            ],
            $responseFactory
        );

        $I->assertInstanceOf(
            ClientInterface::class,
            $client
        );

        $request  = new Request("GET", new Uri("https://example.com/"));
        $response = $client->sendRequest($request);

        $I->assertEquals(200, $response->getStatusCode());
        $I->assertEquals(['text/html; charset=UTF-8'], $response->getHeader('Content-type'));
        $I->assertContains('Example Domain', $response->getBody()->getContents());
    }
}

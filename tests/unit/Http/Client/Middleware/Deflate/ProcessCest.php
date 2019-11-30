<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Client\Middleware\Deflate;

use Cardoe\Http\Client\Middleware\Deflate;
use Cardoe\Http\Client\Middleware\Fallback;
use Cardoe\Http\Client\Request\Handler;
use Cardoe\Http\Client\Transport\Curl;
use Cardoe\Http\Client\Transport\Stream;
use Cardoe\Http\Message\Request;
use Cardoe\Http\Message\ResponseFactory;
use Cardoe\Http\Message\StreamFactory;
use Cardoe\Http\Message\Uri;
use UnitTester;

class ProcessCest
{
    /**
     * Tests Cardoe\Http\Client\Middleware\Deflate :: process() - stream
     *
     * @since  2019-11-21
     */
    public function httpClientMiddlewareDeflateProcessStream(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Middleware\Deflate - process() - stream');

        $responseFactory = new ResponseFactory();
        $streamFactory   = new StreamFactory();
        $handler         = new Handler(
            [
                new Deflate($streamFactory),
                new Stream($streamFactory, $responseFactory),
            ],
            new Fallback($responseFactory)
        );

        $request = new Request(
            'GET',
            new Uri('https://example.com/'),
            'php://temp',
            [
                'Accept-Encoding' => 'gzip',
            ]
        );

        $response = $handler->handle($request);

        $I->assertFalse(
            $response->hasHeader('Content-Encoding')
        );
        $I->assertEquals(
            'gzip',
            $response->getHeader('Content-Encoding-Original')[0]
        );
        $I->assertContains(
            'Example Domain',
            $response->getBody()->getContents()
        );
    }

    /**
     * Tests Cardoe\Http\Client\Middleware\Deflate :: process() - curl
     *
     * @since  2019-11-21
     */
    public function httpClientMiddlewareDeflateProcessCurl(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Middleware\Deflate - process() - curl');

        $responseFactory = new ResponseFactory();
        $streamFactory   = new StreamFactory();
        $handler         = new Handler(
            [
                new Deflate($streamFactory),
                new Curl($streamFactory, $responseFactory),
            ],
            new Fallback($responseFactory)
        );

        $request = new Request(
            'GET',
            new Uri('https://example.com/'),
            'php://temp',
            [
                'Accept-Encoding' => 'gzip',
            ]
        );

        $response = $handler->handle($request);

        $I->assertFalse(
            $response->hasHeader('Content-Encoding')
        );
        $I->assertEquals(
            'gzip',
            $response->getHeader('Content-Encoding-Original')[0]
        );
        $I->assertContains(
            'Example Domain',
            $response->getBody()->getContents()
        );
    }
}

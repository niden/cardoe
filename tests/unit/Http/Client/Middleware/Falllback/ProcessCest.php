<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Client\Middleware\Fallback;

use Cardoe\Http\Client\Client;
use Cardoe\Http\Client\ClientFactory;
use Cardoe\Http\Client\Middleware\Deflate;
use Cardoe\Http\Client\Middleware\Fallback;
use Cardoe\Http\Client\Request\Handler;
use Cardoe\Http\Client\Transport\Stream;
use Cardoe\Http\Message\Request;
use Cardoe\Http\Message\ResponseFactory;
use Cardoe\Http\Message\StreamFactory;
use Cardoe\Http\Message\Uri;
use Psr\Http\Client\ClientInterface;
use UnitTester;

class ProcessCest
{
    /**
     * Tests Cardoe\Http\Client\Middleware\Fallback :: process()
     *
     * @since  2019-11-21
     */
    public function httpClientMiddlewareFallbackProcess(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Middleware\Fallback - process()');

        $responseFactory = new ResponseFactory();
        $handler         = new Handler(
            [],
            new Fallback($responseFactory)
        );

        $request = new Request(
            'GET',
            new Uri('https://example.com/'),
            'php://temp'
        );

        $response = $handler->handle($request);

        $I->assertFalse(
            $response->hasHeader('Content-Encoding')
        );
    }
}

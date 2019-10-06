<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Client\Transport\Curl;

use Cardoe\Http\Client\Middleware\MiddlewareInterface;
use Cardoe\Http\Client\Transport\Curl;
use Cardoe\Http\Client\Transport\TransportInterface;
use Cardoe\Http\Message\ResponseFactory;
use Cardoe\Http\Message\StreamFactory;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Client\Transport\Curl :: __construct()
     *
     * @since  2019-10-06
     */
    public function httpClientTransportCurlConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Client\Transport\Curl - __construct()');

        $stream    = new StreamFactory();
        $response  = new ResponseFactory();
        $transport = new Curl($stream, $response);

        $I->assertInstanceOf(TransportInterface::class, $transport);
        $I->assertInstanceOf(MiddlewareInterface::class, $transport);
    }
}

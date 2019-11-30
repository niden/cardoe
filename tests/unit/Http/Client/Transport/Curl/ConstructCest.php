<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Client\Transport\Curl;

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
     * @since  2019-11-21
     */
    public function httpClientTransportCurlConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Transport\Curl - __construct()');

        $streamFactory   = new StreamFactory();
        $responseFactory = new ResponseFactory();
        $transport       = new Curl($streamFactory, $responseFactory);

        $I->assertInstanceOf(
            Curl::class,
            $transport
        );

        $I->assertInstanceOf(
            TransportInterface::class,
            $transport
        );
    }
}

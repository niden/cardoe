<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Client\ClientFactory;

use Cardoe\Http\Client\Client;
use Cardoe\Http\Client\ClientFactory;
use Cardoe\Http\Message\ResponseFactory;
use Cardoe\Http\Message\StreamFactory;
use Psr\Http\Client\ClientInterface;
use UnitTester;

class NewInstanceCest
{
    /**
     * Tests Cardoe\Http\Client\ClientFactory :: newInstance()
     *
     * @since  2019-11-21
     */
    public function httpClientClientFactoryNewInstance(UnitTester $I)
    {
        $I->wantToTest('Http\Client\ClientFactory - newInstance()');

        $factory         = new ClientFactory();
        $responseFactory = new ResponseFactory();
        $streamFactory   = new StreamFactory();


        $client = $factory
            ->newInstance(
                $responseFactory,
                $streamFactory
            );

        $I->assertInstanceOf(
            Client::class,
            $client
        );

        $I->assertInstanceOf(
            ClientInterface::class,
            $client
        );
    }
}

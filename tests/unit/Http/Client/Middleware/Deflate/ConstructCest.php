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
use Cardoe\Http\Client\Middleware\MiddlewareInterface;
use Cardoe\Http\Message\StreamFactory;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Client\Middleware\Deflate :: __construct()
     *
     * @since  2019-11-21
     */
    public function httpClientMiddlewareDeflateConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Middleware\Deflate - __construct()');

        $streamFactory = new StreamFactory();
        $middleware    = new Deflate($streamFactory);

        $I->assertInstanceOf(
            Deflate::class,
            $middleware
        );

        $I->assertInstanceOf(
            MiddlewareInterface::class,
            $middleware
        );
    }
}

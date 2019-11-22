<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Client\Middleware\Fallback;

use Cardoe\Http\Client\Middleware\Fallback;
use Cardoe\Http\Client\Middleware\MiddlewareInterface;
use Cardoe\Http\Message\ResponseFactory;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Client\Middleware\Fallback :: __construct()
     *
     * @since  2019-11-21
     */
    public function httpClientMiddlewareFallbackConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Middleware\Fallback - __construct()');

        $responseFactory = new ResponseFactory();
        $middleware      = new Fallback($responseFactory);

        $I->assertInstanceOf(
            Fallback::class,
            $middleware
        );

        $I->assertInstanceOf(
            MiddlewareInterface::class,
            $middleware
        );
    }
}

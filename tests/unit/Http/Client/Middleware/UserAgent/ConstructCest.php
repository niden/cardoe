<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Client\Middleware\UserAgent;

use Cardoe\Http\Client\Middleware\MiddlewareInterface;
use Cardoe\Http\Client\Middleware\UserAgent;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Client\Middleware\UserAgent :: __construct()
     *
     * @since  2019-11-21
     */
    public function httpClientMiddlewareUserAgentConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Middleware\UserAgent - __construct()');

        $middleware = new UserAgent('cardoe-agent');

        $I->assertInstanceOf(
            UserAgent::class,
            $middleware
        );

        $I->assertInstanceOf(
            MiddlewareInterface::class,
            $middleware
        );
    }
}

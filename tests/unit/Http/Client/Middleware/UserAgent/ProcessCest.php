<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Client\Middleware\UserAgent;

use Cardoe\Http\Client\Middleware\Closure;
use Cardoe\Http\Client\Middleware\Fallback;
use Cardoe\Http\Client\Middleware\UserAgent;
use Cardoe\Http\Client\Request\Handler;
use Cardoe\Http\Client\Request\HandlerInterface;
use Cardoe\Http\Message\Request;
use Cardoe\Http\Message\ResponseFactory;
use Psr\Http\Message\RequestInterface;
use UnitTester;
use function sprintf;
use const PHP_VERSION;

class ProcessCest
{
    /**
     * Tests Cardoe\Http\Client\Middleware\UserAgent :: process() - default
     *
     * @since  2019-11-21
     */
    public function httpClientMiddlewareUserAgentProcessDefault(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Middleware\UserAgent - process() - default');

        $responseFactory = new ResponseFactory();
        $request         = new Request();

        $I->assertFalse($request->hasHeader('User-Agent'));

        $agent    = new UserAgent();
        $fallback = new Fallback($responseFactory);
        $closure  = new Closure(
            function (RequestInterface $request, HandlerInterface $handler) use ($I) {
                $I->assertTrue(
                    $request->hasHeader('User-Agent')
                );

                $I->assertEquals(
                    sprintf('Cardoe HTTP Client PHP/%s', PHP_VERSION),
                    $request->getHeader('User-Agent')[0]
                );

                return $handler->handle($request);
            }
        );

        $handler = new Handler(
            [
                $agent,
                $closure,
            ],
            $fallback
        );

        $handler->handle($request);
    }

    /**
     * Tests Cardoe\Http\Client\Middleware\UserAgent :: process()
     *
     * @since  2019-11-21
     */
    public function httpClientMiddlewareUserAgentProcess(UnitTester $I)
    {
        $I->wantToTest('Http\Client\Middleware\UserAgent - process()');

        $responseFactory = new ResponseFactory();
        $request         = new Request();

        $I->assertFalse($request->hasHeader('User-Agent'));

        $myAgent  = 'Phalcon Browser/4.0 (PureOS 1.0; Mobile; rv:1.0)';
        $agent    = new UserAgent($myAgent);
        $fallback = new Fallback($responseFactory);
        $closure  = new Closure(
            function (RequestInterface $request, HandlerInterface $handler) use ($I, $myAgent) {
                $I->assertTrue(
                    $request->hasHeader('User-Agent')
                );

                $I->assertEquals(
                    $myAgent,
                    $request->getHeader('User-Agent')[0]
                );

                return $handler->handle($request);
            }
        );

        $handler = new Handler(
            [
                $agent,
                $closure,
            ],
            $fallback
        );

        $handler->handle($request);
    }
}

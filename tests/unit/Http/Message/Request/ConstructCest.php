<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Request;
use Psr\Http\Message\RequestInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: __construct()
     *
     * @since  2019-02-08
     */
    public function httpMessageRequestConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - __construct()');

        $request = new Request();

        $I->assertInstanceOf(
            RequestInterface::class,
            $request
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: __construct() - body exception
     *
     * @since  2019-02-08
     */
    public function httpMessageRequestConstructExceptionBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - __construct() - exception body');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Invalid stream passed as a parameter'
            ),
            function () {
                $request = new Request('GET', null, false);
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: __construct() - exception uri
     *
     * @since  2019-02-08
     */
    public function httpMessageRequestConstructExceptionUri(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - __construct() - exception uri');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Invalid uri passed as a parameter'
            ),
            function () {
                $request = new Request('GET', false);
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: __construct() - exception headers
     *
     * @since  2019-02-08
     */
    public function httpMessageRequestConstructExceptionHeaders(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - __construct() - exception headers');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Headers needs to be either an array or instance of Cardoe\Collection'
            ),
            function () {
                $request = new Request(
                    'GET',
                    '',
                    'php://memory',
                    false
                );
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: __construct() - headers with host
     *
     * @since  2019-02-08
     */
    public function httpMessageRequestConstructHeadersWithHost(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - __construct() - headers with host');

        $request = new Request(
            'GET',
            'https://dev.cardoe.ld:8080/action',
            'php://memory',
            [
                'Host'          => ['test.cardoe.ld'],
                'Accept'        => ['text/html'],
                'Cache-Control' => ['max-age=0'],
            ]
        );

        $expected = [
            'Host'          => ['dev.cardoe.ld:8080'],
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $request->getHeaders();
        $I->assertEquals($expected, $actual);
    }
}

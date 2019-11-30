<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Collection\Collection;
use Cardoe\Http\Message\Request;
use UnitTester;

class GetHeadersCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: getHeaders()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetHeaders(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getHeaders()');

        $data = [
            'Cache-Control' => ['max-age=0'],
            'Accept'        => ['text/html'],
        ];

        $request = new Request(
            'GET',
            null,
            'php://memory',
            $data
        );

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];

        $I->assertEquals(
            $expected,
            $request->getHeaders()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: getHeaders() - collection
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetHeadersCollection(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getHeaders()');

        $data = [
            'Cache-Control' => ['max-age=0'],
            'Accept'        => ['text/html'],
        ];

        $headers = new Collection($data);

        $request = new Request(
            'GET',
            null,
            'php://memory',
            $headers
        );

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];

        $I->assertEquals(
            $expected,
            $request->getHeaders()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: getHeaders() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetHeadersEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getHeaders() - empty');

        $request = new Request();

        $I->assertEquals(
            [],
            $request->getHeaders()
        );
    }
}

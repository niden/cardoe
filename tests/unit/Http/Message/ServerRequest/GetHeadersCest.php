<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Collection\Collection;
use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class GetHeadersCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getHeaders()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetHeaders(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getHeaders()');
        $data    = [
            'Cache-Control' => ['max-age=0'],
            'Accept'        => ['text/html'],
        ];
        $request = new ServerRequest('GET', null, [], 'php://input', $data);

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $request->getHeaders();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getHeaders() - collection
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetHeadersCollection(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getHeaders() - collection');
        $data    = [
            'Cache-Control' => ['max-age=0'],
            'Accept'        => ['text/html'],
        ];
        $headers = new Collection($data);
        $request = new ServerRequest('GET', null, [], 'php://input', $headers);

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $request->getHeaders();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getHeaders() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetHeadersEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getHeaders() - empty');
        $request = new ServerRequest();

        $expected = [];
        $actual   = $request->getHeaders();
        $I->assertEquals($expected, $actual);
    }
}

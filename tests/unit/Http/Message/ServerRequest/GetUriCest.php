<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use Cardoe\Http\Message\Uri;
use UnitTester;

class GetUriCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getUri()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetUri(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getUri()');
        $query   = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri     = new Uri($query);
        $request = new ServerRequest('GET', $uri);

        $expected = $uri;
        $actual   = $request->getUri();
        $I->assertEquals($expected, $actual);
    }
}

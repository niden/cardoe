<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\ServerRequest;

use Phalcon\Http\Message\ServerRequest;
use Phalcon\Http\Message\Uri;
use UnitTester;

class WithUriCest
{
    /**
     * Tests Phalcon\Http\Message\ServerRequest :: withUri()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithUri(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withUri()');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $request     = new ServerRequest();
        $newInstance = $request->withUri($uri);
        $I->assertNotEquals($request, $newInstance);

        $expected = $uri;
        $actual   = $newInstance->getUri();
        $I->assertEquals($expected, $actual);
    }
}

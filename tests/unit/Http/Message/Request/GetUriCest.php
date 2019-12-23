<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Request;

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Uri;
use UnitTester;

class GetUriCest
{
    /**
     * Tests Phalcon\Http\Message\Request :: getUri()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetUri(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getUri()');

        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';

        $uri = new Uri($query);

        $request = new Request('GET', $uri);

        $I->assertEquals(
            $uri,
            $request->getUri()
        );
    }
}

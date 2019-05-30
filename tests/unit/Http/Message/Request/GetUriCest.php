<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Request;
use Cardoe\Http\Message\Uri;
use UnitTester;

class GetUriCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: getUri()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetUri(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getUri()');

        $query = 'https://phalcon:secret@dev.phalcon.ld:8080/action?param=value#frag';

        $uri = new Uri($query);

        $request = new Request('GET', $uri);

        $I->assertEquals(
            $uri,
            $request->getUri()
        );
    }
}

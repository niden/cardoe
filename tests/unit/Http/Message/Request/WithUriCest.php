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

class WithUriCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: withUri()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithUri(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withUri()');

        $query = 'https://phalcon:secret@dev.phalcon.ld:8080/action?param=value#frag';

        $uri = new Uri($query);

        $request = new Request();

        $newInstance = $request->withUri($uri);

        $I->assertNotEquals($request, $newInstance);

        $I->assertEquals(
            $uri,
            $newInstance->getUri()
        );
    }
}

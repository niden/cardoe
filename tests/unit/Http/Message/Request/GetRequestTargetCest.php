<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Request;
use Cardoe\Http\Message\Uri;
use UnitTester;

class GetRequestTargetCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: getRequestTarget()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetRequestTarget(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getRequestTarget()');

        $uri     = new Uri('https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag');
        $request = new Request('GET', $uri);

        $I->assertEquals(
            '/action?param=value',
            $request->getRequestTarget()
        );
    }
}

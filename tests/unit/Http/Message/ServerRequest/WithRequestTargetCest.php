<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class WithRequestTargetCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withRequestTarget()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithRequestTarget(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withRequestTarget()');
        $request     = new ServerRequest();
        $newInstance = $request->withRequestTarget('/test');

        $I->assertNotEquals($request, $newInstance);

        $expected = '/';
        $actual   = $request->getRequestTarget();
        $I->assertEquals($expected, $actual);

        $expected = '/test';
        $actual   = $newInstance->getRequestTarget();
        $I->assertEquals($expected, $actual);
    }
}
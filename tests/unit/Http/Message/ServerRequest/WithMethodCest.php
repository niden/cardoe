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

class WithMethodCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withMethod()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithMethod(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withMethod()');
        $request     = new ServerRequest();
        $newInstance = $request->withMethod('POST');

        $I->assertNotEquals($request, $newInstance);

        $expected = 'GET';
        $actual   = $request->getMethod();
        $I->assertEquals($expected, $actual);

        $expected = 'POST';
        $actual   = $newInstance->getMethod();
        $I->assertEquals($expected, $actual);
    }
}

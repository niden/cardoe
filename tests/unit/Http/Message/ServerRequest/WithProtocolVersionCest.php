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

class WithProtocolVersionCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withProtocolVersion()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithProtocolVersion(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withProtocolVersion()');
        $request     = new ServerRequest();
        $newInstance = $request->withProtocolVersion('2.0');

        $I->assertNotEquals($request, $newInstance);

        $expected = '1.1';
        $actual   = $request->getProtocolVersion();
        $I->assertEquals($expected, $actual);

        $expected = '2.0';
        $actual   = $newInstance->getProtocolVersion();
        $I->assertEquals($expected, $actual);
    }
}

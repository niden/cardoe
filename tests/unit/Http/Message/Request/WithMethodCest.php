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
use UnitTester;

class WithMethodCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: withMethod()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithMethod(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withMethod()');

        $request = new Request();

        $newInstance = $request->withMethod('POST');

        $I->assertNotEquals($request, $newInstance);

        $I->assertEquals(
            'GET',
            $request->getMethod()
        );

        $I->assertEquals(
            'POST',
            $newInstance->getMethod()
        );
    }
}

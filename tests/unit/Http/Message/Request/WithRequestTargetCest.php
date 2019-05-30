<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Request;
use UnitTester;

class WithRequestTargetCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: withRequestTarget()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithRequestTarget(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withRequestTarget()');

        $request = new Request();

        $newInstance = $request->withRequestTarget('/test');

        $I->assertNotEquals($request, $newInstance);

        $I->assertEquals(
            '/',
            $request->getRequestTarget()
        );

        $I->assertEquals(
            '/test',
            $newInstance->getRequestTarget()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: withRequestTarget() - exception
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithRequestTargetException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withRequestTarget() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Invalid request target: cannot contain whitespace'
            ),
            function () {
                $request = new Request();

                $newInstance = $request->withRequestTarget('/te st');
            }
        );
    }
}

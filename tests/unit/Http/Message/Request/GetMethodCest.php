<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Request;

use InvalidArgumentException;
use Cardoe\Http\Message\Request;
use UnitTester;

class GetMethodCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: getMethod()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetMethod(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getMethod()');

        $request = new Request('POST');

        $I->assertEquals(
            'POST',
            $request->getMethod()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: getMethod() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetMethodEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getMethod() - empty');

        $request = new Request();

        $I->assertEquals(
            'GET',
            $request->getMethod()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: getMethod() - exception
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetMethodWxception(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getMethod() - exception');

        $I->expectThrowable(
            new InvalidArgumentException('Invalid or unsupported method UNKNOWN'),
            function () {
                $request = new Request('UNKNOWN');
            }
        );
    }
}

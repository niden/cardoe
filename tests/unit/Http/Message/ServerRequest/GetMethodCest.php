<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use InvalidArgumentException;
use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class GetMethodCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getMethod()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetMethod(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getMethod()');
        $request = new ServerRequest('POST');

        $expected = 'POST';
        $actual   = $request->getMethod();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getMethod() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetMethodEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getMethod() - empty');
        $request = new ServerRequest();

        $expected = 'GET';
        $actual   = $request->getMethod();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getMethod() - exception
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetMethodWxception(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getMethod() - exception');
        $I->expectThrowable(
            new InvalidArgumentException('Invalid or unsupported method UNKNOWN'),
            function () {
                $request = new ServerRequest('UNKNOWN');
            }
        );
    }
}
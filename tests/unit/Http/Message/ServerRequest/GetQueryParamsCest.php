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

class GetQueryParamsCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getQueryParams()
     *
     * @since  2019-03-03
     */
    public function httpMessageServerRequestGetQueryParams(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getQueryParams()');
        $params  = ['one' => 'two'];
        $request = new ServerRequest('GET', null, [], 'php://input', [], [], $params);

        $expected = $params;
        $actual   = $request->getQueryParams();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getQueryParams() - empty
     *
     * @since  2019-03-03
     */
    public function httpMessageServerRequestGetQueryParamsEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getQueryParams() - empty');
        $request = new ServerRequest();

        $actual = $request->getQueryParams();
        $I->assertEmpty($actual);
    }
}

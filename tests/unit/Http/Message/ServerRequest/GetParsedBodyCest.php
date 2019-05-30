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

class GetParsedBodyCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getParsedBody()
     *
     * @since  2019-03-05
     */
    public function httpMessageServerRequestGetParsedBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getParsedBody()');
        $request = new ServerRequest(
            'GET',
            null,
            [],
            'php://input',
            [],
            [],
            [],
            [],
            'something'
        );

        $expected = 'something';
        $actual   = $request->getParsedBody();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getParsedBody() - empty
     *
     * @since  2019-03-05
     */
    public function httpMessageServerRequestGetParsedBodyEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getParsedBody() - empty');
        $request = new ServerRequest();

        $expected = '';
        $actual   = $request->getParsedBody();
        $I->assertEquals($expected, $actual);
    }
}

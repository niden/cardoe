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

class HasHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: hasHeader()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestHasHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - hasHeader()');
        $data    = [
            'Accept' => [
                'text/html',
                'text/json',
            ],
        ];
        $request = new ServerRequest('GET', null, [], 'php://input', $data);

        $actual = $request->hasHeader('accept');
        $I->assertTrue($actual);

        $actual = $request->hasHeader('aCCepT');
        $I->assertTrue($actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: hasHeader() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestHasHeaderEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - hasHeader() - empty');
        $request = new ServerRequest();

        $actual = $request->hasHeader('empty');
        $I->assertFalse($actual);
    }
}

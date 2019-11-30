<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Request;
use UnitTester;

class HasHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: hasHeader()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestHasHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - hasHeader()');

        $data = [
            'Accept' => [
                'text/html',
                'text/json',
            ],
        ];

        $request = new Request('GET', null, 'php://input', $data);

        $I->assertTrue(
            $request->hasHeader('accept')
        );

        $I->assertTrue(
            $request->hasHeader('aCCepT')
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: hasHeader() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestHasHeaderEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - hasHeader() - empty');

        $request = new Request();

        $I->assertFalse(
            $request->hasHeader('empty')
        );
    }
}

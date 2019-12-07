<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Response;

use Cardoe\Http\Message\Response;
use UnitTester;

class GetHeaderLineCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: getHeaderLine()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetHeaderLine(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getHeaderLine()');

        $data = [
            'Accept' => [
                'text/html',
                'text/json',
            ],
        ];

        $response = new Response('php://memory', 200, $data);

        $expected = 'text/html,text/json';

        $I->assertEquals(
            $expected,
            $response->getHeaderLine('accept')
        );

        $I->assertEquals(
            $expected,
            $response->getHeaderLine('aCCepT')
        );
    }

    /**
     * Tests Cardoe\Http\Message\Response :: getHeaderLine() - empty
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetHeaderLineEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getHeaderLine() - empty');

        $response = new Response();

        $I->assertEquals(
            '',
            $response->getHeaderLine('accept')
        );
    }
}

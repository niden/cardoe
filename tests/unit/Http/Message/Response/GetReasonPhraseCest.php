<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Response;

use Cardoe\Http\Message\Response;
use UnitTester;

class GetReasonPhraseCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: getReasonPhrase()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetReasonPhrase(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getReasonPhrase()');

        $response = new Response();

        $I->assertEquals(
            'OK',
            $response->getReasonPhrase()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Response :: getReasonPhrase() - other port
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetReasonPhraseOtherPort(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getReasonPhrase() - other port');

        $response = new Response('php://memory', 420);

        $I->assertEquals(
            'Method Failure',
            $response->getReasonPhrase()
        );
    }
}

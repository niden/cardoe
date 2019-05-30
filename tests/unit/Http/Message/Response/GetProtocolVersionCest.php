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

class GetProtocolVersionCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: getProtocolVersion()
     *
     * @since  2019-03-05
     */
    public function httpMessageResponseGetProtocolVersion(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getProtocolVersion()');

        $response = new Response();

        $I->assertEquals(
            '1.1',
            $response->getProtocolVersion()
        );
    }
}

<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Request;
use UnitTester;

class GetProtocolVersionCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: getProtocolVersion()
     *
     * @since  2019-03-05
     */
    public function httpMessageRequestGetProtocolVersion(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getProtocolVersion()');

        $request = new Request();

        $I->assertEquals(
            '1.1',
            $request->getProtocolVersion()
        );
    }
}
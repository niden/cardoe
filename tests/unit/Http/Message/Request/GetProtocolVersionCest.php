<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Request;

use Phalcon\Http\Message\Request;
use UnitTester;

class GetProtocolVersionCest
{
    /**
     * Tests Phalcon\Http\Message\Request :: getProtocolVersion()
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

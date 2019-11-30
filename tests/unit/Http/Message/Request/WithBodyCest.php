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
use Cardoe\Http\Message\Stream;
use UnitTester;

class WithBodyCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: withBody()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withBody()');

        $fileName = dataDir('/assets/stream/bill-of-rights.txt');

        $stream = new Stream($fileName, 'rb');

        $request = new Request();

        $newInstance = $request->withBody($stream);

        $I->assertNotEquals($request, $newInstance);

        $I->openFile($fileName);

        $I->seeFileContentsEqual(
            $newInstance->getBody()
        );
    }
}

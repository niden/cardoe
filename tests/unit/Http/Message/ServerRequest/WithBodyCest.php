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
use Cardoe\Http\Message\Stream;
use UnitTester;

class WithBodyCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withBody()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withBody()');

        $fileName = dataDir('/assets/stream/bill-of-rights.txt');

        $stream  = new Stream($fileName, 'rb');
        $request = new ServerRequest();

        $newInstance = $request->withBody($stream);

        $I->assertNotEquals($request, $newInstance);

        $I->openFile($fileName);

        $I->seeFileContentsEqual(
            $newInstance->getBody()
        );
    }
}

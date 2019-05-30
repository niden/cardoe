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

class GetBodyCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: getBody()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getBody()');

        $fileName = dataDir('/assets/stream/bill-of-rights.txt');

        $stream = new Stream($fileName, 'rb');

        $request = new Request('GET', null, $stream);

        $I->openFile($fileName);

        $I->seeFileContentsEqual(
            $request->getBody()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: getBody() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestGetBodyEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - getBody() - empty');

        $request = new Request();

        $I->assertInstanceOf(
            Stream::class,
            $request->getBody()
        );
    }
}

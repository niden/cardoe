<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use Cardoe\Http\Message\Stream;
use UnitTester;

class GetBodyCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getBody()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getBody()');

        $fileName = dataDir('/assets/stream/bill-of-rights.txt');

        $stream  = new Stream($fileName, 'rb');
        $request = new ServerRequest('GET', null, [], $stream);

        $I->openFile($fileName);

        $I->seeFileContentsEqual(
            $request->getBody()
        );
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getBody() - empty
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetBodyEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getBody() - empty');

        $request = new ServerRequest();

        $I->assertInstanceOf(
            Stream\Input::class,
            $request->getBody()
        );
    }
}

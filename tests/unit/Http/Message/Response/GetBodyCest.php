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
use Cardoe\Http\Message\Stream;
use UnitTester;

class GetBodyCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: getBody()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getBody()');

        $fileName = dataDir('/assets/stream/bill-of-rights.txt');

        $stream = new Stream($fileName, 'rb');

        $response = new Response($stream);

        $I->openFile($fileName);

        $I->seeFileContentsEqual(
            $response->getBody()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Response :: getBody() - empty
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetBodyEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getBody() - empty');

        $response = new Response();

        $I->assertInstanceOf(
            Stream::class,
            $response->getBody()
        );
    }
}

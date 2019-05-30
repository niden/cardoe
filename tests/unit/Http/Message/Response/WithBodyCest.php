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

class WithBodyCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: withBody()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseWithBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - withBody()');
        $fileName = dataDir('/assets/stream/bill-of-rights.txt');
        $stream   = new Stream($fileName, 'rb');
        $response  = new Response();

        $newInstance = $response->withBody($stream);

        $I->assertNotEquals($response, $newInstance);

        $I->openFile($fileName);

        $I->seeFileContentsEqual(
            $newInstance->getBody()
        );
    }
}

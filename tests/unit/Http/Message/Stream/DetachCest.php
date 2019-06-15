<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Stream;

use Cardoe\Http\Message\Stream;
use UnitTester;

class DetachCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: detach()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamDetach(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - detach()');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $handle   = fopen($fileName, 'rb');
        $stream   = new Stream($handle);

        $actual = $stream->detach();
        $I->assertEquals($handle, $actual);
    }
}

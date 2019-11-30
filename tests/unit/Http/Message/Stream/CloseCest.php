<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Stream;

use Cardoe\Http\Message\Stream;
use UnitTester;

class CloseCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: close()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamClose(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - close()');

        $fileName = dataDir('assets/stream/bill-of-rights.txt');

        $handle = fopen($fileName, 'rb');

        $stream = new Stream($handle);

        $stream->close();

        $I->assertInternalType(
            'resource',
            $handle
        );
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: close() - detach
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamCloseDetach(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - close()');

        $fileName = dataDir('assets/stream/bill-of-rights.txt');

        $handle = fopen($fileName, 'rb');

        $stream = new Stream($handle);

        $stream->close();

        $I->assertNull(
            $stream->detach()
        );
    }
}

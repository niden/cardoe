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
use RuntimeException;
use UnitTester;

class RewindCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: rewind()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamRewind(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - rewind()');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $stream   = new Stream($fileName);

        $stream->seek(10);
        $expected = 10;
        $actual   = $stream->tell();
        $I->assertEquals($expected, $actual);

        $stream->rewind();
        $expected = 0;
        $actual   = $stream->tell();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: rewind() - detached
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamRewindDetached(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - rewind() - detached');
        $I->expectThrowable(
            new RuntimeException(
                'A valid resource is required.'
            ),
            function () {
                $fileName = dataDir('assets/stream/bill-of-rights.txt');
                $stream   = new Stream($fileName, 'rb');
                $stream->detach();

                $stream->rewind();
            }
        );
    }
}

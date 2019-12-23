<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Stream;

use Phalcon\Http\Message\Stream;
use UnitTester;

class EofCest
{
    /**
     * Tests Phalcon\Http\Message\Stream :: eof()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamEof(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - eof()');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $handle   = fopen($fileName, 'rb');
        $stream   = new Stream($handle);
        while (true !== feof($handle)) {
            fread($handle, 1024);
        }

        $actual = $stream->eof();
        $I->assertTrue($actual);
    }

    /**
     * Tests Phalcon\Http\Message\Stream :: eof() - detached stream
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamEofDetached(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - eof() - detached stream');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $stream   = new Stream($fileName, 'rb');
        $stream->detach();

        $actual = $stream->eof();
        $I->assertTrue($actual);
    }

    /**
     * Tests Phalcon\Http\Message\Stream :: eof() - not at eof
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamEofNotAtEof(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - eof() - not at eof');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $stream   = new Stream($fileName, 'rb');
        $stream->seek(10);

        $actual = $stream->eof();
        $I->assertFalse($actual);
    }
}

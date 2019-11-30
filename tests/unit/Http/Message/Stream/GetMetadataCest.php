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
use Cardoe\Test\Fixtures\Http\Message\StreamFixture;
use Codeception\Example;
use UnitTester;

class GetMetadataCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: getMetadata()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamGetMetadata(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - getMetadata()');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $handle   = fopen($fileName, 'rb');
        $stream   = new Stream($handle);

        $expected = [
            'timed_out'    => false,
            'blocked'      => true,
            'eof'          => false,
            'wrapper_type' => 'plainfile',
            'stream_type'  => 'STDIO',
            'mode'         => 'rb',
            'unread_bytes' => 0,
            'seekable'     => true,
            'uri'          => $fileName,
        ];

        $actual = $stream->getMetadata();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: getMetadata() - by key
     *
     * @dataProvider getExamples
     *
     * @since        2019-02-10
     */
    public function httpMessageStreamGetMetadataByKey(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Message\Stream - getMetadata() - by key - ' . $example[0]);
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $handle   = fopen($fileName, 'rb');
        $stream   = new Stream($handle);

        $actual = $stream->getMetadata($example[0]);
        $I->assertEquals($example[1], $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: getMetadata() - invalid handle
     *
     * @since        2019-02-10
     */
    public function httpMessageStreamGetMetadataInvalidHandle(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - getMetadata() - invalid handle');
        $stream = new StreamFixture('php://memory', 'rb');
        $stream->setHandle(null);

        $actual = $stream->getMetadata();
        $I->assertNull($actual);
    }

    private function getExamples(): array
    {
        return [
            ['timed_out', false,],
            ['blocked', true,],
            ['eof', false,],
            ['wrapper_type', 'plainfile',],
            ['stream_type', 'STDIO',],
            ['mode', 'rb',],
            ['unread_bytes', 0,],
            ['seekable', true,],
            ['uri', dataDir('assets/stream/bill-of-rights.txt'),],
            ['unknown', [],],
        ];
    }
}

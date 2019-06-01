<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\UploadedFile;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Stream;
use Cardoe\Http\Message\UploadedFile;
use function outputDir;
use Psr\Http\Message\StreamInterface;
use UnitTester;
use const UPLOAD_ERR_CANT_WRITE;

class GetStreamCest
{
    /**
     * Tests Cardoe\Http\Message\UploadedFile :: getStream()
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileGetStream(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - getStream()');
        $stream = new Stream('php://memory');
        $file   = new UploadedFile(
            $stream,
            0,
            UPLOAD_ERR_OK,
            'phalcon.txt'
        );

        $expected = $stream;
        $actual   = $file->getStream();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: getStream() - string
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileGetStreamString(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - getStream() - string');
        $file = new UploadedFile(
            'php://memory',
            0,
            UPLOAD_ERR_OK,
            'phalcon.txt'
        );

        $actual = $file->getStream();
        $I->assertInstanceOf(StreamInterface::class, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: getStream() - exception
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileGetStreamException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - getStream() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Failed to write file to disk.'
            ),
            function () {
                $stream = new Stream('php://memory');
                $file   = new UploadedFile(
                    $stream,
                    0,
                    UPLOAD_ERR_CANT_WRITE,
                    'phalcon.txt'
                );

                $actual = $file->getStream();
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: getStream() - exception already moved
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileGetStreamExceptionAlreadyMoved(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - getStream() - exception already moved');

        $I->expectThrowable(
            new InvalidArgumentException(
                'The file has already been moved to the target location'
            ),
            function () use ($I) {
                $stream = new Stream('php://memory', 'w+b');
                $stream->write('Cardoe Framework');

                $file   = new UploadedFile($stream, 0);
                $target = $I->getNewFileName();
                $target = outputDir(
                    'tests/stream/' . $target
                );

                $file->moveTo($target);
                $actual = $file->getStream();
            }
        );
    }
}
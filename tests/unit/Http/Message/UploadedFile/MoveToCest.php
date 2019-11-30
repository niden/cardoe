<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\UploadedFile;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Stream;
use Cardoe\Http\Message\UploadedFile;
use UnitTester;

use function outputDir;

class MoveToCest
{
    /**
     * Tests Cardoe\Http\Message\UploadedFile :: moveTo()
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileMoveTo(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - moveTo()');

        $stream = new Stream('php://memory', 'w+b');

        $stream->write('Cardoe Framework');

        $file   = new UploadedFile($stream, 0);
        $target = $I->getNewFileName();
        $target = outputDir(
            'tests/stream/' . $target
        );

        $file->moveTo($target);
        $I->seeFileFound($target);
        $I->openFile($target);

        $I->seeFileContentsEqual(
            (string) $stream
        );
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: moveTo() - upload error
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileMoveToUploadError(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - moveTo() - upload error');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Failed to write file to disk.'
            ),
            function () use ($I) {
                $stream = new Stream('php://memory', 'w+b');

                $stream->write('Cardoe Framework');

                $target = $I->getNewFileName();

                $target = outputDir(
                    'tests/stream/' . $target
                );

                $file = new UploadedFile($stream, 0, UPLOAD_ERR_CANT_WRITE);

                $file->moveTo($target);
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: moveTo() - wrong path
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileMoveToWrongPath(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - moveTo() - wrong path');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Target folder is empty string, not a folder or not writable'
            ),
            function () use ($I) {
                $stream = new Stream('php://memory', 'w+b');

                $stream->write('Cardoe Framework');

                $file = new UploadedFile($stream, 0);

                $file->moveTo(123);
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: moveTo() - already moved
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileMoveToAlreadyMoved(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - moveTo() - already moved');

        $I->expectThrowable(
            new InvalidArgumentException(
                'File has already been moved'
            ),
            function () use ($I) {
                $stream = new Stream('php://memory', 'w+b');

                $stream->write('Cardoe Framework');

                $file = new UploadedFile($stream, 0);

                $target = $I->getNewFileName();

                $target = outputDir(
                    'tests/stream/' . $target
                );

                $file->moveTo($target);
                $file->moveTo($target);
            }
        );
    }
}

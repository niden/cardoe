<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\UploadedFileFactory;

use Phalcon\Http\Message\Stream;
use Phalcon\Http\Message\UploadedFileFactory;
use Psr\Http\Message\UploadedFileInterface;
use UnitTester;

class CreateUploadedFileCest
{
    /**
     * Tests Phalcon\Http\Message\UploadedFileFactory :: createUploadedFile()
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileFactoryCreateUploadedFile(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFileFactory - createUploadedFile()');
        $factory = new UploadedFileFactory();
        $stream  = new Stream('php://temp');
        $file    = $factory->createUploadedFile($stream);
        $class   = UploadedFileInterface::class;
        $I->assertInstanceOf($class, $file);
    }
}

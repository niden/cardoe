<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\UploadedFile;

use Phalcon\Http\Message\UploadedFile;
use UnitTester;

class GetClientMediaTypeCest
{
    /**
     * Tests Phalcon\Http\Message\UploadedFile :: getClientMediaType()
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileGetClientMediaType(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - getClientMediaType()');
        $file = new UploadedFile(
            'php://memory',
            0,
            UPLOAD_ERR_OK,
            'cardoe.txt',
            'some-media-type'
        );

        $expected = 'some-media-type';
        $actual   = $file->getClientMediaType();
        $I->assertEquals($expected, $actual);
    }
}

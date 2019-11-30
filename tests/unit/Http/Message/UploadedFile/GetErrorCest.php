<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\UploadedFile;

use Cardoe\Http\Message\UploadedFile;
use UnitTester;

class GetErrorCest
{
    /**
     * Tests Cardoe\Http\Message\UploadedFile :: getError()
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileGetError(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - getError()');
        $file = new UploadedFile('php://memory', 100);

        $expected = UPLOAD_ERR_OK;
        $actual   = $file->getError();
        $I->assertEquals($expected, $actual);
    }
}

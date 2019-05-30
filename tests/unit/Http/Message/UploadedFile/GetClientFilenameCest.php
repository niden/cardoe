<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\UploadedFile;

use Cardoe\Http\Message\UploadedFile;
use UnitTester;

class GetClientFilenameCest
{
    /**
     * Tests Cardoe\Http\Message\UploadedFile :: getClientFilename()
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileGetClientFilename(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - getClientFilename()');
        $file = new UploadedFile(
            'php://memory',
            0,
            UPLOAD_ERR_OK,
            'phalcon.txt'
        );

        $expected = 'phalcon.txt';
        $actual   = $file->getClientFilename();
        $I->assertEquals($expected, $actual);
    }
}

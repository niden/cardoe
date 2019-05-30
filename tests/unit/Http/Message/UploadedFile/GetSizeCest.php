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

class GetSizeCest
{
    /**
     * Tests Cardoe\Http\Message\UploadedFile :: getSize()
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileGetSize(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - getSize()');
        $file = new UploadedFile('php://memory', 100);

        $expected = 100;
        $actual   = $file->getSize();
        $I->assertEquals($expected, $actual);
    }
}

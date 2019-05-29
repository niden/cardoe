<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Stream;

use Cardoe\Http\Message\Stream;
use Cardoe\Test\Fixtures\Http\Message\StreamFixture;
use function dataDir;
use function fopen;
use UnitTester;

class GetSizeCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: getSize()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamGetSize(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - getSize()');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $expected = filesize($fileName);
        $stream   = new Stream($fileName, 'rb');
        $actual   = $stream->getSize();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: getSize() - invalid stream
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamGetSizeInvalid(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - getSize() - invalid');
        $stream   = new Stream('php://memory', 'rb');
        $expected = 0;
        $actual   = $stream->getSize();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: getSize() - invalid handle
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamGetSizeInvalidHandle(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - getSize() - invalid');
        $stream   = new StreamFixture('php://memory', 'rb');
        $stream->setHandle(null);

        $actual   = $stream->getSize();
        $I->assertNull($actual);
    }
}

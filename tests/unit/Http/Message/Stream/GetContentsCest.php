<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Stream;

use Cardoe\Http\Message\Exception;
use Cardoe\Http\Message\Stream;
use RuntimeException;
use UnitTester;

class GetContentsCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: getContents()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamGetContents(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - getContents()');

        $fileName = dataDir('assets/stream/bill-of-rights.txt');

        $stream = new Stream($fileName, 'rb');

        $I->openFile($fileName);

        $I->seeFileContentsEqual(
            $stream->getContents()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: getContents() - from position
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamGetContentsFromPosition(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - getContents() - from position');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $stream   = new Stream($fileName, 'rb');

        $stream->seek(2169);
        $expected = 'The powers not delegated to the United States by the '
            . 'Constitution, nor prohibited by it to the States, are '
            . 'reserved to the States respectively, or to the people.'
            . "\n";
        $actual   = $stream->getContents();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: getContents() - exception
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamGetContentsException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - getContents() - exception');
        $I->expectThrowable(
            new RuntimeException(
                'The resource is not readable.'
            ),
            function () {
                $fileName = dataDir('assets/stream/bill-of-rights-empty.txt');
                $stream   = new Stream($fileName, 'wb');

                $actual = $stream->getContents();
            }
        );
    }
}
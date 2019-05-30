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

class ReadCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: read()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamRead(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - read()');
        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $stream   = new Stream($fileName, 'rb');

        $expected = 'Congress shall make no law respecting an establishment of '
            . 'religion, or prohibiting the free exercise thereof; or '
            . 'abridging the freedom of speech, or of the press; or the '
            . 'right of the people peaceably to assemble, and to petition '
            . 'the Government for a redress of grievances.';
        $actual   = $stream->read(272);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: read() - detached
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamReadDetached(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - read() - detached');
        $I->expectThrowable(
            new RuntimeException(
                'A valid resource is required.'
            ),
            function () {
                $fileName = dataDir('assets/stream/bill-of-rights.txt');
                $stream   = new Stream($fileName, 'rb');
                $stream->detach();

                $stream->read(10);
            }
        );
    }
}
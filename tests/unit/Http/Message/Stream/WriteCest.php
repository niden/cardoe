<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Stream;

use Cardoe\Http\Message\Stream;
use Cardoe\Test\Fixtures\Http\Message\StreamFixture;
use RuntimeException;
use UnitTester;

use function logsDir;

class WriteCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: write()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamWrite(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - write()');
        $fileName = $I->getNewFileName();
        $fileName = logsDir($fileName);
        $stream   = new Stream($fileName, 'wb');

        $source   = 'A well regulated Militia, being necessary to the security of a free State, '
            . 'the right of the people to keep and bear Arms, shall not be infringed.';
        $expected = strlen($source);
        $actual   = $stream->write($source);
        $I->assertEquals($expected, $actual);

        $stream->close();

        $stream   = new Stream($fileName, 'rb');
        $expected = $source;
        $actual   = $stream->getContents();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: write() - detached
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamWriteDetached(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - write() - detached');
        $I->expectThrowable(
            new RuntimeException(
                'A valid resource is required.'
            ),
            function () use ($I) {
                $fileName = $I->getNewFileName();
                $fileName = logsDir($fileName);
                $stream   = new Stream($fileName, 'wb');
                $stream->detach();

                $stream->write('abc');
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: write() - exception not writable
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamWriteNotWritable(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - write() - exception not writable');

        $fileName = $I->getNewFileName();
        $fileName = logsDir($fileName);
        $stream   = new StreamFixture($fileName, 'wb');

        $I->expectThrowable(
            new RuntimeException(
                'The resource is not writable.'
            ),
            function () use ($stream) {
                $stream->write('abc');
            }
        );
    }
}

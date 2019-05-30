<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\StreamFactory;

use Cardoe\Http\Message\Stream;
use Cardoe\Http\Message\StreamFactory;
use UnitTester;

class CreateStreamFromFileCest
{
    /**
     * Tests Cardoe\Http\Message\StreamFactory :: createStreamFromFile()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamFactoryCreateStreamFromFile(UnitTester $I)
    {
        $I->wantToTest('Http\Message\StreamFactory - createStreamFromFile()');

        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $expected = file_get_contents($fileName);
        $factory  = new StreamFactory();
        $stream   = $factory->createStreamFromFile($fileName);

        $I->assertInstanceOf(
            Stream::class,
            $stream
        );

        $I->assertEquals(
            $expected,
            $stream->getContents()
        );
    }
}

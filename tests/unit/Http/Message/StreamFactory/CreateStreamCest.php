<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\StreamFactory;

use Cardoe\Http\Message\Stream;
use Cardoe\Http\Message\StreamFactory;
use UnitTester;

class CreateStreamCest
{
    /**
     * Tests Cardoe\Http\Message\StreamFactory :: createStream()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamFactoryCreateStream(UnitTester $I)
    {
        $I->wantToTest('Http\Message\StreamFactory - createStream()');

        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $contents = file_get_contents($fileName);
        $factory  = new StreamFactory();
        $stream   = $factory->createStream($contents);

        $I->assertInstanceOf(
            Stream::class,
            $stream
        );

        $I->assertEquals(
            $contents,
            $stream->getContents()
        );
    }
}

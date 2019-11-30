<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\StreamFactory;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Stream;
use Cardoe\Http\Message\StreamFactory;
use UnitTester;

class CreateStreamFromResourceCest
{
    /**
     * Tests Cardoe\Http\Message\StreamFactory :: createStreamFromResource()
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamFactoryCreateStreamFromResource(UnitTester $I)
    {
        $I->wantToTest('Http\Message\StreamFactory - createStreamFromResource()');

        $fileName = dataDir('assets/stream/bill-of-rights.txt');
        $expected = file_get_contents($fileName);
        $resource = fopen($fileName, 'r+b');
        $factory  = new StreamFactory();
        $stream   = $factory->createStreamFromResource($resource);

        $I->assertInstanceOf(
            Stream::class,
            $stream
        );

        $I->assertEquals(
            $expected,
            $stream->getContents()
        );
    }

    /**
     * Tests Cardoe\Http\Message\StreamFactory :: createStreamFromResource() -
     * exception
     *
     * @since  2019-02-10
     */
    public function httpMessageStreamFactoryCreateStreamFromResourceException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\StreamFactory - createStreamFromResource() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Invalid stream provided'
            ),
            function () {
                $factory = new StreamFactory();

                $stream = $factory->createStreamFromResource(false);
            }
        );
    }
}

<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Stream;

use Cardoe\Cache\Adapter\Stream;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

use function outputDir;

class IncrementCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Stream :: increment()
     *
     * @throws Exception
     * @since  2019-04-24
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function cacheAdapterStreamIncrement(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - increment()');

        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $key    = 'cache-data';
        $result = $adapter->set($key, 1);
        $I->assertTrue($result);

        $expected = 2;
        $actual   = $adapter->increment($key);
        $I->assertEquals($expected, $actual);

        $actual = $adapter->get($key);
        $I->assertEquals($expected, $actual);

        $expected = 10;
        $actual   = $adapter->increment($key, 8);
        $I->assertEquals($expected, $actual);

        $actual = $adapter->get($key);
        $I->assertEquals($expected, $actual);

        /**
         * unknown key
         */
        $key    = 'unknown';
        $result = $adapter->increment($key);
        $I->assertFalse($result);
    }
}

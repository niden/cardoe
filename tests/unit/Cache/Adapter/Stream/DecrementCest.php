<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Cache\Adapter\Stream;

use Cardoe\Cache\Adapter\Stream;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use UnitTester;
use function outputDir;

class DecrementCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Stream :: decrement()
     *
     * @throws Exception
     * @since  2019-04-24
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function cacheAdapterStreamDecrement(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - decrement()');
        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $key    = 'cache-data';
        $result = $adapter->set($key, 100);
        $I->assertTrue($result);

        $expected = 99;
        $actual   = $adapter->decrement($key);
        $I->assertEquals($expected, $actual);

        $actual = $adapter->get($key);
        $I->assertEquals($expected, $actual);

        $expected = 90;
        $actual   = $adapter->decrement($key, 9);
        $I->assertEquals($expected, $actual);

        $actual = $adapter->get($key);
        $I->assertEquals($expected, $actual);

        /**
         * unknown key
         */
        $key    = 'unknown';
        $result = $adapter->decrement($key);
        $I->assertFalse($result);
    }
}
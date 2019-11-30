<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Stream;

use Cardoe\Storage\Adapter\Stream;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

use function outputDir;

class IncrementCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Stream :: increment()
     *
     * @throws Exception
     * @since  2019-04-24
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function storageAdapterStreamIncrement(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - increment()');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
            ]
        );

        $key = 'cache-data';

        $I->assertTrue(
            $adapter->set($key, 1)
        );


        $expected = 2;

        $I->assertEquals(
            $expected,
            $adapter->increment($key)
        );

        $I->assertEquals(
            $expected,
            $adapter->get($key)
        );


        $expected = 10;

        $I->assertEquals(
            $expected,
            $adapter->increment($key, 8)
        );

        $I->assertEquals(
            $expected,
            $adapter->get($key)
        );

        /**
         * unknown key
         */
        $key = 'unknown';

        $I->assertFalse(
            $adapter->increment($key)
        );
    }
}

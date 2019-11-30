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
use Cardoe\Storage\SerializerFactory;
use UnitTester;

use function outputDir;
use function uniqid;

class ClearCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Stream :: clear()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterStreamClear(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - clear()');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
            ]
        );

        $key1 = uniqid();
        $key2 = uniqid();
        $adapter->set($key1, 'test');
        $actual = $adapter->has($key1);
        $I->assertTrue($actual);

        $adapter->set($key2, 'test');
        $I->assertTrue(
            $adapter->has($key2)
        );

        $I->assertTrue(
            $adapter->clear()
        );

        $I->assertFalse(
            $adapter->has($key1)
        );

        $I->assertFalse(
            $adapter->has($key2)
        );
    }

    /**
     * Tests Cardoe\Storage\Adapter\Stream :: clear() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterStreamClearTwice(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - clear() - twice');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
            ]
        );

        $key1 = uniqid();
        $key2 = uniqid();
        $adapter->set($key1, 'test');
        $actual = $adapter->has($key1);
        $I->assertTrue($actual);

        $adapter->set($key2, 'test');
        $actual = $adapter->has($key2);
        $I->assertTrue($actual);

        $actual = $adapter->clear();
        $I->assertTrue($actual);

        $actual = $adapter->clear();
        $I->assertTrue($actual);
    }
}

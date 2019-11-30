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
use Cardoe\Storage\SerializerFactory;
use UnitTester;
use function outputDir;

class DeleteCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Stream :: delete()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function cacheAdapterStreamDelete(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - delete()');
        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $key = 'cache-data';
        $adapter->set($key, 'test');
        $actual = $adapter->has($key);
        $I->assertTrue($actual);

        $actual = $adapter->delete($key);
        $I->assertTrue($actual);

        $actual = $adapter->has($key);
        $I->assertFalse($actual);
    }

    /**
     * Tests Cardoe\Cache\Adapter\Stream :: delete() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function cacheAdapterStreamDeleteTwice(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - delete() - twice');
        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $key = 'cache-data';
        $adapter->set($key, 'test');
        $actual = $adapter->has($key);
        $I->assertTrue($actual);

        $actual = $adapter->delete($key);
        $I->assertTrue($actual);

        $actual = $adapter->delete($key);
        $I->assertFalse($actual);
    }

    /**
     * Tests Cardoe\Cache\Adapter\Stream :: delete() - unknown
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function cacheAdapterStreamDeleteUnknown(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - delete() - unknown');

        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $key    = 'cache-data';
        $actual = $adapter->delete($key);
        $I->assertFalse($actual);
    }
}

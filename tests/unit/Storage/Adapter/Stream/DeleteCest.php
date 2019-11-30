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

class DeleteCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Stream :: delete()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function storageAdapterStreamDelete(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - delete()');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
            ]
        );

        $key = 'cache-data';

        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );

        $I->assertTrue(
            $adapter->delete($key)
        );

        $I->assertFalse(
            $adapter->has($key)
        );
    }

    /**
     * Tests Cardoe\Storage\Adapter\Stream :: delete() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function storageAdapterStreamDeleteTwice(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - delete() - twice');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
            ]
        );

        $key = 'cache-data';

        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );

        $I->assertTrue(
            $adapter->delete($key)
        );

        $I->assertFalse(
            $adapter->delete($key)
        );
    }

    /**
     * Tests Cardoe\Storage\Adapter\Stream :: delete() - unknown
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function storageAdapterStreamDeleteUnknown(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - delete() - unknown');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
            ]
        );

        $key = 'cache-data';

        $I->assertFalse(
            $adapter->delete($key)
        );
    }
}

<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Apcu;

use Cardoe\Storage\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class DeleteCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Apcu :: delete()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterApcuDelete(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - delete()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

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
     * Tests Cardoe\Storage\Adapter\Apcu :: delete() - twice
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterApcuDeleteTwice(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - delete() - twice');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

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
     * Tests Cardoe\Storage\Adapter\Apcu :: delete() - unknown
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterApcuDeleteUnknown(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - delete() - unknown');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $key    = 'cache-data';
        $actual = $adapter->delete($key);
        $I->assertFalse($actual);
    }
}

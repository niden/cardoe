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

namespace Cardoe\Test\Unit\Storage\Adapter\Apcu;

use Exception;
use Cardoe\Storage\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class DecrementCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Apcu :: decrement()
     *
     * @throws Exception
     * @since  2019-03-31
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function storageAdapterApcuDecrement(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - decrement()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $key    = uniqid();
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
    }
}

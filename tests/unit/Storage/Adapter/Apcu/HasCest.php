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

use Cardoe\Storage\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class HasCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Apcu :: get()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterApcuGetSetHas(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - has()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $key = uniqid();

        $actual = $adapter->has($key);
        $I->assertFalse($actual);

        $adapter->set($key, 'test');
        $actual = $adapter->has($key);
        $I->assertTrue($actual);
    }
}

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

namespace Cardoe\Test\Unit\Cache\Adapter\Apcu;

use Cardoe\Cache\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class GetKeysCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Apcu :: getKeys()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-13
     */
    public function cacheAdapterApcuGetKeys(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - getKeys()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $adapter->clear();


        $key = 'key-1';

        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );


        $key = 'key-2';

        $adapter->set($key, 'test');

        $I->assertTrue(
            $adapter->has($key)
        );


        $expected = [
            'ph-apcu-key-1',
            'ph-apcu-key-2',
        ];
        $actual   = $adapter->getKeys();
        sort($actual);
        $I->assertEquals($expected, $actual);
    }
}

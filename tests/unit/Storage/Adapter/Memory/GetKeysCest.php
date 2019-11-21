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

namespace Cardoe\Test\Unit\Storage\Adapter\Memory;

use Cardoe\Storage\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class GetKeysCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Memory :: getKeys()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-13
     */
    public function storageAdapterMemoryGetKeys(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Memory - getKeys()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $adapter->clear();

        $key = 'key-1';
        $adapter->set($key, 'test');
        $actual = $adapter->has($key);
        $I->assertTrue($actual);

        $key = 'key-2';
        $adapter->set($key, 'test');
        $actual = $adapter->has($key);
        $I->assertTrue($actual);

        $expected = [
            'ph-memo-key-1',
            'ph-memo-key-2',
        ];
        $actual   = $adapter->getKeys();
        sort($actual);
        $I->assertEquals($expected, $actual);
    }
}

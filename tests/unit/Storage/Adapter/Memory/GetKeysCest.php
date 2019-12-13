<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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

        $I->assertTrue($adapter->clear());

        $adapter->set('key-1', 'test');
        $adapter->set('key-2', 'test');
        $adapter->set('one-1', 'test');
        $adapter->set('one-2', 'test');

        $I->assertTrue($adapter->has('key-1'));
        $I->assertTrue($adapter->has('key-2'));
        $I->assertTrue($adapter->has('one-1'));
        $I->assertTrue($adapter->has('one-2'));

        $expected = [
            'ph-memo-key-1',
            'ph-memo-key-2',
            'ph-memo-one-1',
            'ph-memo-one-2',
        ];
        $actual   = $adapter->getKeys();
        sort($actual);
        $I->assertEquals($expected, $actual);

        $expected = [
            'ph-memo-one-1',
            'ph-memo-one-2',
        ];
        $actual   = $adapter->getKeys("one");
        sort($actual);
        $I->assertEquals($expected, $actual);
    }
}

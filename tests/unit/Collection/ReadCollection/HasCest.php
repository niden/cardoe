<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Collection\ReadCollection;

use Cardoe\Collection\ReadCollection;
use UnitTester;

class HasCest
{
    /**
     * Tests Cardoe\Collection\ReadCollection :: has()
     *
     * @since  2018-11-13
     */
    public function collectionHas(UnitTester $I)
    {
        $I->wantToTest('Collection\ReadCollection - has()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new ReadCollection($data);

        $I->assertTrue(
            $collection->has('three')
        );

        $I->assertTrue(
            $collection->has('THREE')
        );

        $I->assertFalse(
            $collection->has('unknown')
        );

        $I->assertTrue(
            $collection->__isset('three')
        );

        $I->assertTrue(
            isset($collection['three'])
        );

        $I->assertFalse(
            isset($collection['unknown'])
        );

        $I->assertTrue(
            $collection->offsetExists('three')
        );

        $I->assertFalse(
            $collection->offsetExists('unknown')
        );
    }

    /**
     * Tests Cardoe\Collection\ReadCollection :: has() - sensitive
     *
     * @since  2018-11-13
     */
    public function collectionHasSensitive(UnitTester $I)
    {
        $I->wantToTest('Collection\Collection - has()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new ReadCollection($data, false);

        $I->assertTrue(
            $collection->has('three')
        );

        $I->assertFalse(
            $collection->has('THREE')
        );

        $I->assertFalse(
            $collection->has('unknown')
        );

        $I->assertTrue(
            $collection->__isset('three')
        );

        $I->assertTrue(
            isset($collection['three'])
        );

        $I->assertFalse(
            isset($collection['unknown'])
        );

        $I->assertTrue(
            $collection->offsetExists('three')
        );

        $I->assertFalse(
            $collection->offsetExists('unknown')
        );
    }
}

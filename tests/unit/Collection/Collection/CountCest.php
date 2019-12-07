<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Collection\Collection;

use Cardoe\Collection\Collection;
use UnitTester;

class CountCest
{
    /**
     * Tests Cardoe\Collection\Collection :: count()
     *
     * @since  2018-11-13
     */
    public function collectionCount(UnitTester $I)
    {
        $I->wantToTest('Collection\Collection - count()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new Collection($data);

        $I->assertCount(
            3,
            $collection->toArray()
        );

        $I->assertEquals(
            3,
            $collection->count()
        );
    }
}

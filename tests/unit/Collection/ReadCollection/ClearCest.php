<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Collection\ReadCollection;

use Cardoe\Collection\ReadCollection;
use UnitTester;

class ClearCest
{
    /**
     * Tests Cardoe\Collection\ReadCollection :: clear()
     *
     * @since  2018-11-13
     */
    public function collectionClear(UnitTester $I)
    {
        $I->wantToTest('Collection\ReadCollection - clear()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new ReadCollection($data);

        $I->assertEquals(
            $data,
            $collection->toArray()
        );

        $collection->clear();

        $I->assertEquals(
            0,
            $collection->count()
        );
    }
}

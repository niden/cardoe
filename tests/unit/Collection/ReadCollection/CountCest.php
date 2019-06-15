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

class CountCest
{
    /**
     * Tests Cardoe\Collection\ReadCollection :: count()
     *
     * @since  2018-11-13
     */
    public function collectionCount(UnitTester $I)
    {
        $I->wantToTest('Collection\ReadCollection - count()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new ReadCollection($data);

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

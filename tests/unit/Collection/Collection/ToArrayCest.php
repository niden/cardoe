<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Collection\Collection;

use Cardoe\Collection\Collection;
use UnitTester;

class ToArrayCest
{
    /**
     * Tests Cardoe\Collection\Collection :: toArray()
     *
     * @since  2018-11-13
     */
    public function collectionToArray(UnitTester $I)
    {
        $I->wantToTest('Collection - toArray()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new Collection($data);

        $I->assertEquals(
            $data,
            $collection->toArray()
        );
    }
}

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

class GetIteratorCest
{
    /**
     * Tests Cardoe\Collection\Collection :: getIterator()
     *
     * @since  2018-11-13
     */
    public function collectionGetIterator(UnitTester $I)
    {
        $I->wantToTest('Collection\Collection - getIterator()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new Collection($data);

        foreach ($collection as $key => $value) {
            $I->assertEquals(
                $data[$key],
                $collection[$key]
            );
        }
    }
}

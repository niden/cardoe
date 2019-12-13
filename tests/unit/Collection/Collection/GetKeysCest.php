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

class GetKeysCest
{
    /**
     * Unit Tests Cardoe\Collection\Collection :: getKeys()
     *
     * @since  2019-12-12
     */
    public function collectionCollectionGetKeys(UnitTester $I)
    {
        $I->wantToTest('Collection\Collection - getKeys()');

        $keys = [
            'one',
            'three',
            'five',
        ];

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new Collection($data);

        $I->assertEquals($keys, $collection->getKeys());

        $data = [
            'one'   => 'two',
            'Three' => 'four',
            'five'  => 'six',
        ];

        $collection = new Collection($data);
        $I->assertEquals($keys, $collection->getKeys());
        $I->assertEquals(array_keys($data), $collection->getKeys(false));
    }
}

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

class RemoveCest
{
    /**
     * Tests Cardoe\Collection\Collection :: remove()
     *
     * @since  2018-11-13
     */
    public function collectionRemove(UnitTester $I)
    {
        $I->wantToTest('Collection\Collection - remove()');
        $data       = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];
        $collection = new Collection($data);

        $expected = $data;
        $actual   = $collection->toArray();
        $I->assertEquals($expected, $actual);

        $collection->remove('five');
        $expected = [
            'one'   => 'two',
            'three' => 'four',
        ];
        $actual   = $collection->toArray();
        $I->assertEquals($expected, $actual);

        $collection->remove('FIVE');
        $expected = [
            'one'   => 'two',
            'three' => 'four',
        ];
        $actual   = $collection->toArray();
        $I->assertEquals($expected, $actual);

        $collection->init($data);
        unset($collection['five']);
        $expected = [
            'one'   => 'two',
            'three' => 'four',
        ];
        $actual   = $collection->toArray();
        $I->assertEquals($expected, $actual);

        $collection->init($data);
        $collection->__unset('five');
        $expected = [
            'one'   => 'two',
            'three' => 'four',
        ];
        $actual   = $collection->toArray();
        $I->assertEquals($expected, $actual);

        $collection->init($data);
        $collection->offsetUnset('five');
        $expected = [
            'one'   => 'two',
            'three' => 'four',
        ];
        $actual   = $collection->toArray();
        $I->assertEquals($expected, $actual);
    }
}

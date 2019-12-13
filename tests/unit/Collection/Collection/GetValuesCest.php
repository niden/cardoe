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

class GetValuesCest
{
    /**
     * Unit Tests Cardoe\Collection\Collection :: getValues()
     *
     * @since  2019-12-12
     */
    public function collectionCollectionGetValues(UnitTester $I)
    {
        $I->wantToTest('Collection\Collection - getValues()');

        $values = [
            'two',
            'four',
            'six',
        ];

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new Collection($data);

        $I->assertEquals($values, $collection->getValues());
    }
}

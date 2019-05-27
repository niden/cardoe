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

class SetCest
{
    /**
     * Tests Cardoe\Collection :: set()
     *
     * @since  2018-11-13
     */
    public function collectionSet(UnitTester $I)
    {
        $I->wantToTest('Collection - set()');

        $collection = new Collection();

        $collection->set('three', 'two');

        $I->assertEquals(
            'two',
            $collection->get('three')
        );

        $collection->three = 'Cardoe';

        $I->assertEquals(
            'Cardoe',
            $collection->get('three')
        );

        $collection->offsetSet('three', 123);

        $I->assertEquals(
            123,
            $collection->get('three')
        );


        $collection['three'] = true;

        $I->assertTrue(
            $collection->get('three')
        );
    }
}

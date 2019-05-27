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

class InitCest
{
    /**
     * Tests Cardoe\Collection :: init()
     *
     * @since  2018-11-13
     */
    public function collectionInit(UnitTester $I)
    {
        $I->wantToTest('Collection - init()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new ReadCollection();

        $I->assertEquals(
            0,
            $collection->count()
        );

        $collection->init($data);

        $I->assertEquals(
            $data,
            $collection->toArray()
        );
    }
}

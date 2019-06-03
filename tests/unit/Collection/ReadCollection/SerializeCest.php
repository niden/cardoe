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

class SerializeCest
{
    /**
     * Tests Cardoe\Collection\ReadCollection :: serialize()
     *
     * @since  2018-11-13
     */
    public function collectionSerialize(UnitTester $I)
    {
        $I->wantToTest('ReadCollection - serialize()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new ReadCollection($data);

        $I->assertEquals(
            serialize($data),
            $collection->serialize()
        );
    }
}

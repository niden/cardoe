<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\None;

use Cardoe\Storage\Serializer\None;
use UnitTester;

class SetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\None :: getData()
     *
     * @since  2019-03-30
     */
    public function storageSerializerNoneSetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\None - setData()');
        $data       = ['Cardoe Framework'];
        $serializer = new None();

        $actual = $serializer->getData();
        $I->assertNull($actual);

        $serializer->setData($data);

        $expected = $data;
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }
}

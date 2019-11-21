<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Msgpack;

use Cardoe\Storage\Serializer\Msgpack;
use UnitTester;

class GetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Msgpack :: getData()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-30
     */
    public function storageSerializerMsgpackGetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Msgpack - getData()');
        $data       = ['Cardoe Framework'];
        $serializer = new Msgpack($data);

        $expected = $data;
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }
}

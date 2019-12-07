<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Serializer\Json;

use Cardoe\Storage\Serializer\Json;
use UnitTester;

class SetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Json :: getData()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-30
     */
    public function storageSerializerJsonSetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Json - setData()');
        $data       = ['Cardoe Framework'];
        $serializer = new Json();

        $actual = $serializer->getData();
        $I->assertNull($actual);

        $serializer->setData($data);

        $expected = $data;
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }
}

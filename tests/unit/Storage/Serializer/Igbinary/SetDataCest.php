<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Serializer\Igbinary;

use Cardoe\Storage\Serializer\Igbinary;
use UnitTester;

class SetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Igbinary :: getData()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-30
     */
    public function storageSerializerIgbinarySetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Igbinary - setData()');
        $data       = ['Cardoe Framework'];
        $serializer = new Igbinary();

        $actual = $serializer->getData();
        $I->assertNull($actual);

        $serializer->setData($data);

        $expected = $data;
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }
}

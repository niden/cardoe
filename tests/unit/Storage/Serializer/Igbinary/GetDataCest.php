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

class GetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Igbinary :: getData()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-30
     */
    public function storageSerializerIgbinaryGetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Igbinary - getData()');
        $data       = ['Cardoe Framework'];
        $serializer = new Igbinary($data);

        $expected = $data;
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }
}

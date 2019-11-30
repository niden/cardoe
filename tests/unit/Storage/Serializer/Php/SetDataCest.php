<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Serializer\Php;

use Cardoe\Storage\Serializer\Php;
use UnitTester;

class SetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Php :: setData()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-12
     */
    public function storageSerializerPhpSetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Php - setData()');
        $data       = ['Cardoe Framework'];
        $serializer = new Php();

        $actual = $serializer->getData();
        $I->assertNull($actual);

        $serializer->setData($data);

        $expected = $data;
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }
}

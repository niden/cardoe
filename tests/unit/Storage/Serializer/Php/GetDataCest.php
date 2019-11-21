<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Php;

use Cardoe\Storage\Serializer\Php;
use UnitTester;

class GetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Php :: getData()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-12
     */
    public function storageSerializerPhpGetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Php - getData()');
        $data       = ['Cardoe Framework'];
        $serializer = new Php($data);

        $expected = $data;
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }
}

<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Json;

use Cardoe\Storage\Serializer\Json;
use UnitTester;

class GetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Json :: getData()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-30
     */
    public function storageSerializerJsonGetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Json - getData()');
        $data       = ['Cardoe Framework'];
        $serializer = new Json($data);

        $expected = $data;
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }
}

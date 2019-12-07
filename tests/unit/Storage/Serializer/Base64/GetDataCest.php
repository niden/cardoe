<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Serializer\Base64;

use Cardoe\Storage\Serializer\Base64;
use UnitTester;

class GetDataCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Base64 :: getData()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-30
     */
    public function storageSerializerBase64GetData(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Base64 - getData()');

        $data       = ['Cardoe Framework'];
        $serializer = new Base64($data);

        $I->assertEquals(
            $data,
            $serializer->getData()
        );
    }
}

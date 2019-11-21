<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Base64;

use Cardoe\Storage\Serializer\Base64;
use InvalidArgumentException;
use UnitTester;

class SerializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Base64 :: serialize()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-30
     */
    public function storageSerializerBase64Serialize(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Base64 - serialize()');

        $data       = 'Cardoe Framework';
        $serializer = new Base64($data);

        $I->assertEquals(
            base64_encode($data),
            $serializer->serialize()
        );
    }

    /**
     * Tests Cardoe\Storage\Serializer\Base64 :: serialize() - exception
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-30
     */
    public function storageSerializerBase64SerializeException(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Base64 - serialize() - exception');
        $I->expectThrowable(
            new InvalidArgumentException(
                'Data for the serializer must of type string'
            ),
            function () {
                $serializer = new Base64(1234);
                $serializer->serialize();
            }
        );
    }
}

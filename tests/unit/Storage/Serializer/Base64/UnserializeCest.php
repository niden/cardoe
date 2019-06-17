<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Base64;

use Cardoe\Storage\Serializer\Base64;
use InvalidArgumentException;
use UnitTester;

class UnserializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Base64 :: unserialize()
     *
     * @since  2019-03-30
     */
    public function storageSerializerBase64Unserialize(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Base64 - unserialize()');

        $data       = 'Cardoe Framework';
        $serializer = new Base64($data);
        $serialized = base64_encode($data);
        $serializer->unserialize($serialized);

        $I->assertEquals(
            $data,
            $serializer->getData()
        );
    }

    /**
     * Tests Cardoe\Storage\Serializer\Base64 :: serialize() - exception
     *
     * @since  2019-03-30
     */
    public function storageSerializerBase64SerializeException(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\Base64 - unserialize() - exception');
        $I->expectThrowable(
            new InvalidArgumentException(
                'Data for the unserializer must of type string'
            ),
            function () {
                $serializer = new Base64();
                $serializer->unserialize(1234);
            }
        );
    }
}

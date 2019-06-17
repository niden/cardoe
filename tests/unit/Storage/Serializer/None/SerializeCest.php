<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\None;

use Cardoe\Storage\Serializer\None;
use UnitTester;

class SerializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\None :: serialize()
     *
     * @since  2019-03-30
     */
    public function storageSerializerNoneSerialize(UnitTester $I)
    {
        $I->wantToTest('Storage\Serializer\None - serialize()');
        $data       = ['Cardoe Framework'];
        $serializer = new None($data);

        $expected = $data;
        $actual   = $serializer->serialize();
        $I->assertEquals($expected, $actual);
    }
}

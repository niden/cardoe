<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Helper\Json;

use InvalidArgumentException;
use Cardoe\Helper\Json;
use UnitTester;

class EncodeCest
{
    /**
     * Tests Cardoe\Helper\Json :: encode()
     *
     * @since  2019-12-01
     */
    public function helperJsonEncode(UnitTester $I)
    {
        $I->wantToTest('Helper\Json - encode()');

        $data     = [
            'one' => 'two',
            'three',
        ];
        $expected = '{"one":"two","0":"three"}';
        $actual   = Json::encode($data);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Json :: encode() - exception
     *
     * @since  2019-12-01
     */
    public function helperJsonEncodeException(UnitTester $I)
    {
        $I->wantToTest('Helper\Json - encode() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                "json_encode error: Malformed UTF-8 characters, " .
                "possibly incorrectly encoded"
            ),
            function () {
                $data   = pack("H*", 'c32e');
                $actual = Json::encode($data);
            }
        );
    }
}

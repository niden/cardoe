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

class DecodeCest
{
    /**
     * Tests Cardoe\Helper\Json :: decode()
     *
     * @since  2019-12-01
     */
    public function helperJsonDecode(UnitTester $I)
    {
        $I->wantToTest('Helper\Json - decode()');

        $data     = '{"one":"two","0":"three"}';
        $expected = [
            'one' => 'two',
            'three',
        ];
        $actual   = Json::decode($data, true);
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Helper\Json :: decode() - exception
     *
     * @since  2019-12-01
     */
    public function helperJsonDecodeException(UnitTester $I)
    {
        $I->wantToTest('Helper\Json - decode() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                "json_decode error: Control character error, " .
                "possibly incorrectly encoded"
            ),
            function () {
                $data   = '{"one';
                $actual = Json::decode($data);
            }
        );
    }
}

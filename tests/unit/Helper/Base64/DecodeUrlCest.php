<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Helper\Base64;

use Cardoe\Helper\Base64;
use UnitTester;

class DecodeUrlCest
{
    /**
     * Tests Cardoe\Helper\Base64 :: decodeUrl()
     *
     * @since  2019-12-12
     */
    public function helperBase64Decode(UnitTester $I)
    {
        $I->wantToTest('Helper\Base64 - decodeUrl()');

        $source   = 'aHR0cHM6Ly9jYXJkb2UubGQ_b25lPXR3byZkYXRhPWpzb24rdmRp';
        $expected = 'https://cardoe.ld?one=two&data=json+vdi';
        $actual = Base64::decodeUrl($source);
        $I->assertEquals($expected, $actual);
    }
}

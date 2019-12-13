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

class EncodeUrlCest
{
    /**
     * Tests Cardoe\Helper\Base64 :: encodeUrl()
     *
     * @since  2019-12-12
     */
    public function helperBase64Encode(UnitTester $I)
    {
        $I->wantToTest('Helper\Base64 - encodeUrl()');

        $url      = 'https://cardoe.ld?one=two&data=json+vdi';
        $expected = 'aHR0cHM6Ly9jYXJkb2UubGQ_b25lPXR3byZkYXRhPWpzb24rdmRp';
        $actual = Base64::encodeUrl($url);
        $I->assertEquals($expected, $actual);
    }
}

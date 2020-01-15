<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Helper\Base64;

use Phalcon\Helper\Base64;
use UnitTester;

class EncodeUrlCest
{
    /**
     * Tests Phalcon\Helper\Base64 :: encodeUrl()
     *
     * @since  2019-12-12
     */
    public function helperBase64Encode(UnitTester $I)
    {
        $I->wantToTest('Helper\Base64 - encodeUrl()');

        $url      = 'https://phalcon.ld?one=two&data=json+vdi';
        $expected = 'aHR0cHM6Ly9waGFsY29uLmxkP29uZT10d28mZGF0YT1qc29uK3ZkaQ';
        $actual   = Base64::encodeUrl($url);
        $I->assertEquals($expected, $actual);
    }
}

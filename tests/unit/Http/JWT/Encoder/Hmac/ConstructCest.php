<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Encoder\Hmac;

use Phalcon\Http\JWT\Encoder\Hmac;
use Phalcon\Http\JWT\Exceptions\UnsupportedAlgorithmException;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Encoder\Hmac :: __construct()
     *
     * @since  2019-12-15
     */
    public function httpJWTEncoderHmacConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Encoder\Hmac - __construct()');

        $encoder = new Hmac();
        $I->assertInstanceOf(Hmac::class, $encoder);
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Encoder\Hmac :: __construct() - exception
     *
     * @since  2019-12-15
     */
    public function httpJWTEncoderHmacConstructException(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Encoder\Hmac - __construct() - exception');

        $I->expectThrowable(
            new UnsupportedAlgorithmException(
                'Unsupported HMAC algorithm'
            ),
            function () {
                $encoder = new Hmac('unknown');
            }
        );
    }
}

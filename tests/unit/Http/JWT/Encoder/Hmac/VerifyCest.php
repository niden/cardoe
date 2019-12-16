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
use UnitTester;

use function hash_hmac;

class VerifyCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Encoder\Hmac :: verify()
     *
     * @since  2019-12-15
     */
    public function httpJWTEncoderHmacVerify(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Encoder\Hmac - verify()');

        $encoder = new Hmac();

        $payload    = 'test payload';
        $passphrase = '12345';

        $hash   = hash_hmac('sha512', $payload, $passphrase, true);
        $actual = $encoder->verify($hash, $payload, $passphrase);
        $I->assertTrue($actual);
    }
}

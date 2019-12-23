<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Validator;

use Phalcon\Http\JWT\Exceptions\ValidatorException;
use Phalcon\Http\JWT\Signer\Hmac;
use Phalcon\Http\JWT\Validator;
use Phalcon\Test\Fixtures\Traits\JWTTrait;
use UnitTester;

class ValidateSignatureCest
{
    use JWTTrait;

    /**
     * Unit Tests Phalcon\Http\JWT\Validator :: validateSignature()
     *
     * @since  2019-12-22
     */
    public function httpJWTValidatorValidateNotBefore(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Validator - validateSignature()');

        $signer     = new Hmac();
        $passphrase = '&vsJBETaizP3A3VX&TPMJUqi48fJEgN7';
        $token      = $this->newToken();
        $validator = new Validator($token);
        $I->assertInstanceOf(Validator::class, $validator);

        $I->assertInstanceOf(
            Validator::class,
            $validator->validateSignature($signer, $passphrase)
        );
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Validator :: validateSignature() - exception
     *
     * @since  2019-12-22
     */
    public function httpJWTValidatorValidateNotBeforeException(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Validator - validateSignature()');

        $token = $this->newToken();
        $I->expectThrowable(
            new ValidatorException(
                "Validation: the token cannot be used yet (not before)"
            ),
            function () use ($token, $I) {
                $signer     = new Hmac();
                $passphrase = '123456';
                $validator = new Validator($token);
                $I->assertInstanceOf(Validator::class, $validator);

                $I->assertInstanceOf(
                    Validator::class,
                    $validator->validateSignature($signer, $passphrase)
                );
            }
        );
    }
}

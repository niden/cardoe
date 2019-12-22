<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Builder;

use Phalcon\Http\JWT\Builder;
use Phalcon\Http\JWT\Exceptions\ValidatorException;
use Phalcon\Http\JWT\Signer\Hmac;
use Phalcon\Http\JWT\Signer\None;
use Phalcon\Http\JWT\Token\Token;
use Phalcon\Http\JWT\Validator;
use UnitTester;

class GetTokenCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: getToken()
     *
     * @since  2019-12-19
     */
    public function httpJWTBuilderGetToken(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - getToken()');

        $signer    = new Hmac();
        $signer    = new None();
        $validator = new Validator();
        $builder   = new Builder($signer, $validator);

        $expiry = strtotime('+1 day');
        $issued = strtotime('now');
        $notBefore = strtotime('-1 day');
        $passphrase = '&vsJBETaizP3A3VX&TPMJUqi48fJEgN7';
        $token = $builder
            ->setAudience('my-audience')
            ->setExpirationTime($expiry)
            ->setIssuer('Phalcon JWT')
            ->setIssuedAt($issued)
            ->setId('PH-JWT')
            ->setNotBefore($notBefore)
            ->setSubject('Mary had a little lamb')
            ->setPassphrase($passphrase)
            ->getToken()
        ;

        $I->assertInstanceOf(Token::class, $token);

        $parts = explode('.', $token->getToken());
        $I->assertCount(3, $parts);
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: getToken() - exception
     *
     * @since  2019-12-19
     */
    public function httpJWTBuilderGetTokenException(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - getToken() - exception');

        $I->expectThrowable(
            new ValidatorException(
                'Invalid passphrase (empty)'
            ),
            function () {
                $signer    = new Hmac();
                $validator = new Validator();
                $builder   = new Builder($signer, $validator);

                $token = $builder->getToken();
            }
        );
    }
}

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
use Phalcon\Http\JWT\Signer\Hmac;
use Phalcon\Http\JWT\Validator;
use UnitTester;

class GetClaimsCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: getClaims()
     *
     * @since  2019-12-19
     */
    public function httpJWTBuilderGetClaims(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - getClaims()');

        $signer    = new Hmac();
        $validator = new Validator();
        $builder   = new Builder($signer, $validator);

        $future = strtotime("now") + 1000;
        $builder
            ->setAudience('audience')
            ->setExpirationTime($future)
            ->setId('id')
            ->setIssuedAt(8)
            ->setIssuer('issuer')
            ->setNotBefore(4)
            ->setSubject('subject')
        ;

        $expected = [
            'aud' => 'audience',
            'exp' => $future,
            'jti' => 'id',
            'iat' => 8,
            'iss' => 'issuer',
            'nbf' => 4,
            'sub' => 'subject',
        ];
        $actual   = $builder->getClaims();
        $I->assertEquals($expected, $actual);
    }
}

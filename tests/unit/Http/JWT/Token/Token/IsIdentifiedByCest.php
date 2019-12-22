<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Token\Token;

use Phalcon\Http\JWT\Token\Item;
use Phalcon\Http\JWT\Token\Signature;
use Phalcon\Http\JWT\Token\Token;
use UnitTester;

class IsIdentifiedByCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token\Token :: isIdentifiedBy()
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenTokenIsIdentifiedBy(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Token - isIdentifiedBy()');

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["aud" => ["valid-audience"]], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertFalse($token->isIdentifiedBy("abc"));

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["jti" => "jti-id"], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertFalse($token->isIdentifiedBy("unknown"));

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["jti" => "jti-id"], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertTrue($token->isIdentifiedBy("jti-id"));
    }
}

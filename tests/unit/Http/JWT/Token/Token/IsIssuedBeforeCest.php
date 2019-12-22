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

class IsIssuedBeforeCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token\Token :: isIssuedBefore()
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenTokenIsIssuedBefore(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Token - isIssuedBefore()');

        $now       = strtotime("now");
        $future    = strtotime("+1 day");
        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["aud" => ["valid-audience"]], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertTrue($token->isIssuedBefore(4));

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["iat" => $future], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertFalse($token->isIssuedBefore($now));

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["iat" => $now], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertTrue($token->isIssuedBefore($future));
    }
}

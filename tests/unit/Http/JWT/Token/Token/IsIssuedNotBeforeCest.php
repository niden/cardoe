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

class IsIssuedNotBeforeCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token\Token :: isIssuedNotBefore()
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenTokenIsIssuedNotBefore(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Token - isIssuedNotBefore()');

        $now       = strtotime("now");
        $future    = strtotime("+1 day");
        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["aud" => ["valid-audience"]], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertTrue($token->isIssuedNotBefore(4));

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["nbf" => $future], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertFalse($token->isIssuedNotBefore($now));

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["nbf" => $now], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertTrue($token->isIssuedNotBefore($future));
    }
}

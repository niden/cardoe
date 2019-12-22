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

class IsExpiredCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token\Token :: isExpired()
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenTokenIsExpired(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Token - isExpired()');

        $now       = strtotime("now");
        $past      = strtotime("-1 day");
        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["aud" => ["valid-audience"]], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertFalse($token->isExpired(4));

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["exp" => $now], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertFalse($token->isExpired($past));

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["exp" => $past], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertTrue($token->isExpired($now));
    }
}

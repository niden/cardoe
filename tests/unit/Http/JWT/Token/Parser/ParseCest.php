<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Token\Parser;

use Phalcon\Http\JWT\Token\Parser;
use Phalcon\Http\JWT\Token\Token;
use UnitTester;

class ParseCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token\Parser :: parse()
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenParserParse(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Parser - parse()');

        $tokenString = "eyJhdWQiOlsibXktYXVkaWVuY2UiXSwiZXhwIjoxNTc3MTM5MzM"
                     . "2LCJpc3MiOiJQaGFsY29uIEpXVCIsImlhdCI6MTU3NzA1MjkzNi"
                     . "wianRpIjoiUEgtSldUIiwibmJmIjoxNTc2OTY2NTM2LCJzdWIiOi"
                     . "JNYXJ5IGhhZCBhIGxpdHRsZSBsYW1iIn0."
                     . "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9."
                     . "9Yk20U13-blvBGIC0RfSbfpw03N0axr5jyCaGOKN4Wo4Z102Ity"
                     . "B_p_iLMp-4TVIHBn_i4KEu5Tw2N_4HUIvrw";

        $parser = new Parser();

        $token = $parser->parse($tokenString);
        $I->assertInstanceOf(Token::class, $token);

        $headers   = $token->getHeaders();
        $claims    = $token->getClaims();
        $signature = $token->getSignature();

        $I->assertIsArray($headers);
        $I->assertIsArray($claims);
        $I->assertIsString($signature);

        $I->assertArrayHasKey("typ", $headers);
        $I->assertArrayHasKey("alg", $headers);

        $I->assertEquals("JWT", $headers["typ"]);
        $I->assertEquals("HS512", $headers["alg"]);

        $I->assertArrayHasKey("aud", $claims);
        $I->assertArrayHasKey("exp", $claims);
        $I->assertArrayHasKey("jti", $claims);
        $I->assertArrayHasKey("iat", $claims);
        $I->assertArrayHasKey("iss", $claims);
        $I->assertArrayHasKey("nbf", $claims);
        $I->assertArrayHasKey("sub", $claims);

        $I->assertEquals(["my-audience"], $claims["aud"]);
        $I->assertEquals(1577139336, $claims["exp"]);
        $I->assertEquals("PH-JWT", $claims["jti"]);
        $I->assertEquals(1577052936, $claims["iat"]);
        $I->assertEquals("Phalcon JWT", $claims["iss"]);
        $I->assertEquals(1576966536, $claims["nbf"]);
        $I->assertEquals("Mary had a little lamb", $claims["sub"]);
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Token\Parser :: parse() - no signature
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenParserParseNoSignature(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Parser - parse() - no signature');

        $tokenString = "eyJhdWQiOlsibXktYXVkaWVuY2UiXSwiZXhwIjoxNTc3MTQxNzc"
                     . "3LCJpc3MiOiJQaGFsY29uIEpXVCIsImlhdCI6MTU3NzA1NTM3Nyw"
                     . "ianRpIjoiUEgtSldUIiwibmJmIjoxNTc2OTY4OTc3LCJzdWIiOiJ"
                     . "NYXJ5IGhhZCBhIGxpdHRsZSBsYW1iIn0."
                     . "eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.";

        $parser = new Parser();

        $token = $parser->parse($tokenString);
        $I->assertInstanceOf(Token::class, $token);

        $headers   = $token->getHeaders();
        $claims    = $token->getClaims();
        $signature = $token->getSignature();

        $I->assertIsArray($headers);
        $I->assertIsArray($claims);
        $I->assertIsString($signature);

        $I->assertArrayHasKey("typ", $headers);
        $I->assertArrayHasKey("alg", $headers);

        $I->assertEquals("JWT", $headers["typ"]);
        $I->assertEquals("none", $headers["alg"]);

        $I->assertArrayHasKey("aud", $claims);
        $I->assertArrayHasKey("exp", $claims);
        $I->assertArrayHasKey("jti", $claims);
        $I->assertArrayHasKey("iat", $claims);
        $I->assertArrayHasKey("iss", $claims);
        $I->assertArrayHasKey("nbf", $claims);
        $I->assertArrayHasKey("sub", $claims);

        $I->assertEquals(["my-audience"], $claims["aud"]);
        $I->assertEquals(1577141777, $claims["exp"]);
        $I->assertEquals("PH-JWT", $claims["jti"]);
        $I->assertEquals(1577055377, $claims["iat"]);
        $I->assertEquals("Phalcon JWT", $claims["iss"]);
        $I->assertEquals(1576968977, $claims["nbf"]);
        $I->assertEquals("Mary had a little lamb", $claims["sub"]);

        $I->assertEmpty($signature);
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Token\Parser :: parse() - aud not an array
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenParserParseAudNotAnArray(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Parser - parse() - aud not an array');

        $tokenString = "eyJhdWQiOiJteS1hdWRpZW5jZSIsImV4cCI6MTU3NzE0MTkxN"
                     . "ywiaXNzIjoiUGhhbGNvbiBKV1QiLCJpYXQiOjE1NzcwNTU1MTc"
                     . "sImp0aSI6IlBILUpXVCIsIm5iZiI6MTU3Njk2OTExNywic3ViIj"
                     . "oiTWFyeSBoYWQgYSBsaXR0bGUgbGFtYiJ9."
                     . "eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.";

        $parser = new Parser();

        $token = $parser->parse($tokenString);
        $I->assertInstanceOf(Token::class, $token);

        $headers   = $token->getHeaders();
        $claims    = $token->getClaims();
        $signature = $token->getSignature();

        $I->assertIsArray($headers);
        $I->assertIsArray($claims);
        $I->assertIsString($signature);

        $I->assertArrayHasKey("typ", $headers);
        $I->assertArrayHasKey("alg", $headers);

        $I->assertEquals("JWT", $headers["typ"]);
        $I->assertEquals("none", $headers["alg"]);

        $I->assertArrayHasKey("aud", $claims);
        $I->assertArrayHasKey("exp", $claims);
        $I->assertArrayHasKey("jti", $claims);
        $I->assertArrayHasKey("iat", $claims);
        $I->assertArrayHasKey("iss", $claims);
        $I->assertArrayHasKey("nbf", $claims);
        $I->assertArrayHasKey("sub", $claims);

        $I->assertEquals(["my-audience"], $claims["aud"]);
        $I->assertEquals(1577141917, $claims["exp"]);
        $I->assertEquals("PH-JWT", $claims["jti"]);
        $I->assertEquals(1577055517, $claims["iat"]);
        $I->assertEquals("Phalcon JWT", $claims["iss"]);
        $I->assertEquals(1576969117, $claims["nbf"]);
        $I->assertEquals("Mary had a little lamb", $claims["sub"]);

        $I->assertEmpty($signature);
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Token\Parser :: parse() - exception claims not array
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenParserParseExceptionClaimsNotArray(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Parser - parse() - exception claims not array');

        $I->expectThrowable(
            new \InvalidArgumentException(
                "Invalid Claims (not an array)"
            ),
            function () {
                $tokenString = "Im9uZSI."
                             . "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9."
                             . "cbY2T8Wty9ejBnDuvivja3BelmRx1Z_YRlaLlFkv0EkXA"
                             . "873JhKg_rbU6MdhsTXa9fmFGSvc87x-5HvUD1kMWA";

                $parser = new Parser();
                $token  = $parser->parse($tokenString);
            }
        );
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Token\Parser :: parse() - exception headers not array
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenParserParseExceptionHeadersNotArray(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Parser - parse() - exception headers not array');

        $I->expectThrowable(
            new \InvalidArgumentException(
                "Invalid Header (not an array)"
            ),
            function () {
                $tokenString = "eyJhdWQiOlsibXktYXVkaWVuY2UiXSwiZXhwIjoxNTc3MTQwNjI"
                    . "yLCJpc3MiOiJQaGFsY29uIEpXVCIsImlhdCI6MTU3NzA1NDIyMiw"
                    . "ianRpIjoiUEgtSldUIiwibmJmIjoxNTc2OTY3ODIyLCJzdWIiOiJN"
                    . "YXJ5IGhhZCBhIGxpdHRsZSBsYW1iIn0."
                    . "Im9uZXR3byI."
                    . "8wA9TNxo7BufOGtpih5j2DHebuF5YbCuptSZC_UL35WrQisOv2Mx"
                    . "EcI7fkz4z2YYKavLKKKUPFPsLuYsZ3cFRw";

                $parser = new Parser();
                $token  = $parser->parse($tokenString);
            }
        );
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Token\Parser :: parse() - exception no typ
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenParserParseExceptionNoTyp(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Parser - parse() - exception no typ');

        $I->expectThrowable(
            new \InvalidArgumentException(
                "Invalid Header (missing 'typ' element)"
            ),
            function () {
                $tokenString = "eyJhdWQiOlsibXktYXVkaWVuY2UiXSwiZXhwIjoxNT"
                             . "c3MTQwODAyLCJpc3MiOiJQaGFsY29uIEpXVCIsImlhd"
                             . "CI6MTU3NzA1NDQwMiwianRpIjoiUEgtSldUIiwibmJmI"
                             . "joxNTc2OTY4MDAyLCJzdWIiOiJNYXJ5IGhhZCBhIGxpd"
                             . "HRsZSBsYW1iIn0."
                             . "eyJhbGciOiJIUzUxMiJ9."
                             . "1IVBMm7v7oQtDtAatiINF4eHAGzwW7cdMsiBNJgpxFe"
                             . "NZyt7n9CxBDidUENQE03ybMYrIpASZVidVFinVL4g1g";

                $parser = new Parser();
                $token  = $parser->parse($tokenString);
            }
        );
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Token\Parser :: parse() - exception wrong JWT
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenParserParseExceptionWrongJwt(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Parser - parse() - exception wrong JWT');

        $I->expectThrowable(
            new \InvalidArgumentException(
                "Invalid JWT string (dots misalignment)"
            ),
            function () {
                $tokenString = "eyJhdWQiOlsibXktYXVkaWVuY2UiXSwiZXhwIjoxNT";

                $parser = new Parser();
                $token  = $parser->parse($tokenString);
            }
        );
    }

}

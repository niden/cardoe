<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Token;

use Phalcon\Http\JWT\Token;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token :: __construct()
     *
     * @since  2019-12-19
     */
    public function httpJWTTokenConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token - __construct()');

        $token = new Token('one', 'two');

        $I->assertInstanceOf(Token::class, $token);
    }
}

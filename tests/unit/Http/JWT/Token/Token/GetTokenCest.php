<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Token\Token;

use UnitTester;

class GetTokenCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token\Token :: getToken()
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenTokenGetToken(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Token - getToken()');

        $I->skipTest('Need implementation');
    }
}

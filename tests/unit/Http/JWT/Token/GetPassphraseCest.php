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

class GetPassphraseCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token :: getPassphrase()
     *
     * @since  2019-12-19
     */
    public function httpJWTTokenGetPassphrase(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token - getPassphrase()');

        $token = new Token('one', 'two');

        $I->assertEquals('one', $token->getToken());
    }
}

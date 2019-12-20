<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Validator;

use Phalcon\Http\JWT\Validator;
use UnitTester;

class ExpirationCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Validator :: expiration()
     *
     * @since  2019-12-19
     */
    public function httpJWTValidatorExpiration(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Validator - expiration()');

        $validator = new Validator();

        $future = strtotime("now") + 1000;
        $I->assertTrue($validator->expiration($future));
        $I->assertFalse($validator->expiration(4));
    }
}

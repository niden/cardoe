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

class NotBeforeCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Validator :: notBefore()
     *
     * @since  2019-12-19
     */
    public function httpJWTValidatorNotBefore(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Validator - notBefore()');

        $validator = new Validator();

        $future = strtotime("now") + 1000;
        $I->assertTrue($validator->notBefore(4));
        $I->assertFalse($validator->notBefore($future));
    }
}

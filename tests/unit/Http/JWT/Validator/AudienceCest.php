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

class AudienceCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Validator :: audience()
     *
     * @since  2019-12-19
     */
    public function httpJWTValidatorAudience(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Validator - audience()');

        $validator = new Validator();

        $I->assertFalse($validator->audience(1234));
        $I->assertTrue($validator->audience('abcdef'));
        $I->assertTrue($validator->audience(['abcdef']));
    }
}

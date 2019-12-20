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

class PassphraseCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Validator :: passphrase()
     *
     * @since  2019-12-19
     */
    public function httpJWTValidatorPassphrase(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Validator - passphrase()');

        $validator = new Validator();

        $I->assertFalse($validator->passphrase('1234'));
        $I->assertTrue(
            $validator->passphrase('6U#5xK!uFmUtwRZ3SCLjC*K%i8f@4MNE')
        );
    }
}

<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Builder;

use Phalcon\Http\JWT\Builder;
use Phalcon\Http\JWT\Exceptions\ValidateException;
use UnitTester;

class SetPassphraseCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: setPassphrase()
     *
     * @since  2019-12-15
     *
     * @throws ValidateException
     */
    public function httpJWTBuilderSetPassphrase(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - setPassphrase()');

        $builder = new Builder();
        $passphrase = '6U#5xK!uFmUtwRZ3SCLjC*K%i8f@4MNE';
        $return = $builder->setPassphrase($passphrase);
        $I->assertInstanceOf(Builder::class, $return);
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: setPassphrase() - exception
     *
     * @since  2019-12-15
     */
    public function httpJWTBuilderSetPassphraseException(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - setPassphrase() - exception');

        $I->expectThrowable(
            new ValidateException(
                'Invalid passphrase (too weak)'
            ),
            function () {
                $builder = new Builder();
                $builder->setPassphrase('1234');
            }
        );
    }
}

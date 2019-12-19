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
use Phalcon\Http\JWT\Exceptions\ValidatorException;
use Phalcon\Http\JWT\Validator;
use UnitTester;

class GetSetAudienceCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: getAudience()/setAudience()
     *
     * @since  2019-12-15
     */
    public function httpJWTBuilderGetSetAudience(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - getAudience()/setAudience()');

        $validator = new Validator();
        $builder   = new Builder($validator);

        $I->assertNull($builder->getAudience());

        $return = $builder->setAudience('audience');
        $I->assertInstanceOf(Builder::class, $return);

        $I->assertEquals('audience', $builder->getAudience());

        $return = $builder->setAudience(['audience']);
        $I->assertInstanceOf(Builder::class, $return);

        $I->assertEquals(['audience'], $builder->getAudience());
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: setAudience() - exception
     *
     * @since  2019-12-15
     */
    public function httpJWTBuilderSetAudienceException(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - setAudience() - exception');

        $I->expectThrowable(
            new ValidatorException(
                "Invalid Audience"
            ),
            function () {
                $validator = new Validator();
                $builder   = new Builder($validator);
                $return    = $builder->setAudience(1234);
            }
        );
    }
}

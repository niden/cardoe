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
use UnitTester;

class GetSetExpirationTimeCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: getExpirationTime()/setExpirationTime()
     *
     * @since  2019-12-15
     */
    public function httpJWTBuilderGetSetExpirationTime(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - getExpirationTime()/setExpirationTime()');

        $builder = new Builder();

        $I->assertNull($builder->getExpirationTime());

        $return = $builder->setExpirationTime(4);
        $I->assertInstanceOf(Builder::class, $return);

        $I->assertEquals(4, $builder->getExpirationTime());
    }
}

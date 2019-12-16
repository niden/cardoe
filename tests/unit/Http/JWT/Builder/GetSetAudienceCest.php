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

        $builder = new Builder();

        $I->assertNull($builder->getAudience());

        $return = $builder->setAudience('audience');
        $I->assertInstanceOf(Builder::class, $return);

        $I->assertEquals('audience', $builder->getAudience());
    }
}

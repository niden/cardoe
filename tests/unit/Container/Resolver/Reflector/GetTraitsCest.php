<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Reflector;

use Phalcon\Container\Resolver\Reflector;
use Phalcon\Test\Fixtures\Container\WithTraitClass;
use UnitTester;

class GetTraitsCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Reflector :: getTraits()
     *
     * @since  2019-12-30
     */
    public function containerResolverReflectorGetTraits(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Reflector - getTraits()');

        $reflector = new Reflector();
        $return    = $reflector->getTraits(WithTraitClass::class);
        $I->assertIsArray($return);
        $I->assertCount(3, $return);
    }
}

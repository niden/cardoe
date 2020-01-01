<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\AutoResolver;

use Phalcon\Container\Resolver\AutoResolver;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\ValueObject;
use UnitTester;

class TypesCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\AutoResolver :: types()
     *
     * @since  2019-12-30
     */
    public function containerResolverAutoResolverTypes(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\AutoResolver - types()');

        $resolver = new AutoResolver(new Reflector());
        $I->assertInstanceOf(ValueObject::class, $resolver->types());

        $resolver->types()->set('typeOne', 'two');
        $I->assertEquals(1, $resolver->types()->count());
    }
}

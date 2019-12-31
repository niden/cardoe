<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Resolver;

use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Container\Resolver\ValueObject;
use UnitTester;

class MutationsCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: mutations()
     *
     * @since  2019-12-31
     */
    public function containerResolverResolverMutations(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - mutations()');

        $resolver = new Resolver(new Reflector());
        $I->assertInstanceOf(ValueObject::class, $resolver->mutations());

        $resolver->mutations()->set('mutationOne', ['mutation' => 'two']);
        $I->assertEquals(1, $resolver->mutations()->count());
    }
}

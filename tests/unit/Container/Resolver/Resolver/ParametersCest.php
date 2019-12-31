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

class ParametersCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: parameters()
     *
     * @since  2019-12-31
     */
    public function containerResolverResolverParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - parameters()');

        $resolver = new Resolver(new Reflector());
        $I->assertInstanceOf(ValueObject::class, $resolver->parameters());

        $resolver->parameters()->set('parameterOne', ['one' => 'two']);
        $I->assertEquals(1, $resolver->parameters()->count());
    }
}

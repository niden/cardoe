<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\AutoResolver;

use Phalcon\Container\Exception\MissingParameter;
use Phalcon\Container\Injection\LazyNew;
use Phalcon\Container\Resolver\AutoResolver;
use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Test\Fixtures\Container\ChildFixtureClass;
use Phalcon\Test\Fixtures\Container\ParametersFixtureClass;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use Phalcon\Test\Fixtures\Container\ResolveFixtureClass;
use UnitTester;

class ResolveCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\AutoResolver :: resolve() -
     * without parameter
     *
     * @since  2019-12-30
     */
    public function containerResolverAutoResolverResolveWithoutParameter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\AutoResolver - resolve() - without parameter');

        $resolver = new AutoResolver(new Reflector());

        $actual = $resolver->resolve(new Blueprint(ResolveFixtureClass::class));
        $I->assertInstanceOf(ParentFixtureClass::class, $actual->class);
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\AutoResolver :: resolve() -
     * explicit
     *
     * @since  2019-12-30
     */
    public function containerResolverAutoResolverResolveExplicit(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\AutoResolver - resolve() - explicit');

        $resolver = new AutoResolver(new Reflector());
        $resolver->types()->set(
            ParentFixtureClass::class,
            new LazyNew(
                $resolver,
                new Blueprint(ChildFixtureClass::class)
            )
        )
        ;

        $actual = $resolver->resolve(new Blueprint(ResolveFixtureClass::class));
        $I->assertInstanceOf(ChildFixtureClass::class, $actual->class);
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\AutoResolver :: resolve() -
     * exception missing parameter
     *
     * @since  2019-12-30
     */
    public function containerResolverAutoResolverResolveMissingParameter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\AutoResolver - resolve() - exception missing parameter');

        $I->expectThrowable(
            new MissingParameter(
                'Parameter missing: Phalcon\Test\Fixtures\Container\ParametersFixtureClass::$data'
            ),
            function () {
                $resolver = new AutoResolver(new Reflector());
                $resolver->resolve(new Blueprint(ParametersFixtureClass::class));
            }
        );
    }
}

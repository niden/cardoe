<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Resolver;

use Phalcon\Container\Exception\MissingParameter;
use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Test\Fixtures\Container\ChildFixtureClass;
use Phalcon\Test\Fixtures\Container\ParametersFixtureClass;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use Phalcon\Test\Fixtures\Container\ResolveFixtureClass;
use ReflectionException;
use UnitTester;

class ResolveCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: resolve() - positional
     * parameters
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverResolvePositionalParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - resolve() - positional parameters');

        $resolver = new Resolver(new Reflector());
        $resolver
            ->parameters()
            ->set(
                ParentFixtureClass::class,
                [
                    0 => 'tuvok',
                ]
            )
            ->set(
                ChildFixtureClass::class,
                [
                    1 => 30,
                ]
            )
        ;

        $blueprint = $resolver->resolve(new Blueprint(ChildFixtureClass::class));
        $expected  = [
            'name'  => 'tuvok',
            'other' => 30,
        ];
        $I->assertEquals(
            $expected,
            [
                'name'  => $blueprint->getStore(),
                'other' => $blueprint->getOther(),
            ]
        );

    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: resolve() - exception
     * missing class
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverResolveMissingClass(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - resolve() - exception missing class');

        $I->expectThrowable(
            new ReflectionException(
                'Class unknownClass does not exist',
                -1
            ),
            function () {
                $resolver = new Resolver(new Reflector());
                $resolver->resolve(new Blueprint('unknownClass'));
            }
        );
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: resolve() - exception
     * missing parameter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverResolveMissingParameter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - resolve() - exception missing parameter');

        $I->expectThrowable(
            new MissingParameter(
                'Parameter missing: Phalcon\Test\Fixtures\Container\ResolveFixtureClass::$class'
            ),
            function () {
                $resolver = new Resolver(new Reflector());
                $resolver->resolve(new Blueprint(ResolveFixtureClass::class));
            }
        );
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: resolve() - exception
     * unresolved parameter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverResolveUnresolvedParameter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - resolve() - exception unresolved parameter');

        $I->expectThrowable(
            new MissingParameter(
                'Parameter missing: Phalcon\Test\Fixtures\Container\ParametersFixtureClass::$data'
            ),
            function () {
                $resolver = new Resolver(new Reflector());
                $resolver->resolve(
                    new Blueprint(
                        ParametersFixtureClass::class,
                        [
                            'unknownParameter' => 'borg',
                        ]
                    )
                );
            }
        );
    }
}

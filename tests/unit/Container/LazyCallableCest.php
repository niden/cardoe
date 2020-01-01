<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use Phalcon\Container\Builder;
use Phalcon\Container\Injection\LazyCallable;
use Phalcon\Test\Fixtures\Container\InvokableFixtureClass;
use UnitTester;

class LazyCallableCest
{
    /**
     * Unit Tests Phalcon\Container :: lazyCallable()
     *
     * @since  2020-01-01
     */
    public function containerLazyCallable(UnitTester $I)
    {
        $I->wantToTest('Container - lazyCallable()');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $callable = $container->lazyCallable(
            $container->lazyNew(InvokableFixtureClass::class)
        );
        $runner   = function (callable $callable) {
            return $callable(' of nine');
        };

        $I->assertInstanceOf(LazyCallable::class, $callable);

        $actual   = $runner($callable);
        $expected = 'seven of nine';
        $I->assertEquals($expected, $actual);
    }

    /**
     * Unit Tests Phalcon\Container :: lazyCallable() - with array containing
     * lazy
     *
     * @since  2020-01-01
     */
    public function containerLazyCallableWithArrayContainingLazy(UnitTester $I)
    {
        $I->wantToTest('Container - lazyCallable() - with array containing lazy');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $container->set(
            'invokable',
            $container->lazyNew(
                InvokableFixtureClass::class,
                [
                    'name' => 'tuvok',
                ]
            )
        );

        $callable = $container->lazyCallable(
            [
                $container->lazyGet('invokable'),
                '__invoke',
            ]
        );
        $runner   = function (callable $callable) {
            return $callable(' of vulcan');
        };

        $I->assertInstanceOf(LazyCallable::class, $callable);

        $actual = $runner($callable);
        $expect = 'tuvok of vulcan';
        $I->assertEquals($expect, $actual);
    }
}

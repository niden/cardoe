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
use Phalcon\Container\Injection\Lazy;
use Phalcon\Test\Fixtures\Container\MalleableFixtureClass;
use Phalcon\Test\Fixtures\Container\MeldingFixtureClass;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use UnitTester;

class LazyCest
{
    /**
     * Unit Tests Phalcon\Container :: lazy()
     *
     * @since  2020-01-01
     */
    public function containerLazy(UnitTester $I)
    {
        $I->wantToTest('Container - lazy()');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazy = $container->lazy(
            $container->lazyNew(MeldingFixtureClass::class),
            $container->lazyNew(MalleableFixtureClass::class, ['name' => 'seven'])
        );
        $I->assertInstanceOf(Lazy::class, $lazy);

        $malleable = $lazy();
        $I->assertInstanceOf(MalleableFixtureClass::class, $malleable);

        $actual = $malleable->getName();
        $I->assertEquals('tuvok', $actual);
    }

    /**
     * Unit Tests Phalcon\Container :: lazy() - array containing lazy
     *
     * @since  2020-01-01
     */
    public function containerLazyArrayContainingLazy(UnitTester $I)
    {
        $I->wantToTest('Container - lazy() - array containing lazy');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazy = $container->lazy(
            [
                $container->lazyNew(ParentFixtureClass::class),
                'mirror',
            ],
            $container->lazy(
                function () {
                    return 'harry';
                }
            )
        );
        $I->assertInstanceOf(Lazy::class, $lazy);

        $actual = $lazy();
        $I->assertEquals('harry', $actual);
    }
}

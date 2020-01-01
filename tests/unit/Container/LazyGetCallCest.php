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
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use UnitTester;

class LazyGetCallCest
{
    /**
     * Unit Tests Phalcon\Container :: lazyGetCall()
     *
     * @since  2020-01-01
     */
    public function containerLazyGetCall(UnitTester $I)
    {
        $I->wantToTest('Container - lazyGetCall()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container->set(
            'parent',
            $container->lazyNew(ParentFixtureClass::class)
        );

        $lazy = $container->lazyGetCall(
            'parent',
            'mirror',
            'tuvok'
        );

        $I->assertInstanceOf(Lazy::class, $lazy);

        $expect = 'tuvok';
        $actual = $lazy();
        $I->assertEquals($expect, $actual);
    }
}

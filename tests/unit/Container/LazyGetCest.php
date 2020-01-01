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
use Phalcon\Container\Injection\LazyGet;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use UnitTester;

class LazyGetCest
{
    /**
     * Unit Tests Phalcon\Container :: lazyGet()
     *
     * @since  2020-01-01
     */
    public function containerLazyGet(UnitTester $I)
    {
        $I->wantToTest('Container - lazyGet()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container->set(
            'other',
            function () {
                return new OtherFixtureClass();
            }
        );

        $lazy = $container->lazyGet('other');
        $I->assertInstanceOf(LazyGet::class, $lazy);

        $actual = $lazy();
        $I->assertInstanceOf(OtherFixtureClass::class, $actual);
    }
}

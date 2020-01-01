<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Builder;

use Phalcon\Container\Builder;
use Phalcon\Container\Resolver\AutoResolver;
use Phalcon\Container\Resolver\Resolver;
use Psr\Container\ContainerInterface;
use UnitTester;

class NewInstanceCest
{
    /**
     * Unit Tests Phalcon\Container\Builder :: newInstance()
     *
     * @since  2019-12-30
     */
    public function containerBuilderNewInstance(UnitTester $I)
    {
        $I->wantToTest('Container\Builder - newInstance()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $I->assertInstanceOf(ContainerInterface::class, $container);
        $I->assertInstanceOf(Resolver::class, $container->getInjectionFactory()->getResolver());
    }

    /**
     * Unit Tests Phalcon\Container\Builder :: newInstance() - autoresolver
     *
     * @since  2019-12-30
     */
    public function containerBuilderNewInstanceAutoresolver(UnitTester $I)
    {
        $I->wantToTest('Container\Builder - newInstance() - autoresolver');

        $builder   = new Builder();
        $container = $builder->newInstance(true);
        $I->assertInstanceOf(ContainerInterface::class, $container);
        $I->assertInstanceOf(AutoResolver::class, $container->getInjectionFactory()->getResolver());
    }
}

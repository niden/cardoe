<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use Phalcon\Container;
use Phalcon\Container\Injection\InjectionFactory;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Test\Fixtures\Container\ContainerFixture;
use UnitTester;

class GetDelegateContainerCest
{
    /**
     * Unit Tests Phalcon\Container :: getDelegateContainer()
     *
     * @since  2020-01-01
     */
    public function containerGetDelegateContainer(UnitTester $I)
    {
        $I->wantToTest('Container - getDelegateContainer()');

        $container = new Container(
            new InjectionFactory(new Resolver(new Reflector())),
            new ContainerFixture([])
        );

        $I->assertInstanceOf(ContainerFixture::class, $container->getDelegateContainer());
    }
}

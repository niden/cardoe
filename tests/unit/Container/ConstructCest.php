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
use Psr\Container\ContainerInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container :: __construct()
     *
     * @since  2020-01-01
     */
    public function containerConstruct(UnitTester $I)
    {
        $I->wantToTest('Container - __construct()');

        $container = new Container(
            new InjectionFactory(new Resolver(new Reflector()))
        );

        $I->assertInstanceOf(ContainerInterface::class, $container);
        $I->assertInstanceOf(Container::class, $container);
    }
}

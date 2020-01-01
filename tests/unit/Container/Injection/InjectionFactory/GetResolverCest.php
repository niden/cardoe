<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\InjectionFactory;

use Phalcon\Container\Injection\InjectionFactory;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use UnitTester;

class GetResolverCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\InjectionFactory :: getResolver()
     *
     * @since  2019-12-30
     */
    public function containerInjectionInjectionFactoryGetResolver(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\InjectionFactory - getResolver()');

        $factory = new InjectionFactory(new Resolver(new Reflector()));
        $I->assertInstanceOf(Resolver::class, $factory->getResolver());
    }
}

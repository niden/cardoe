<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\AutoResolver;

use Phalcon\Container\Resolver\AutoResolver;
use Phalcon\Container\Resolver\Reflector;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\AutoResolver :: __construct()
     *
     * @since  2019-12-30
     */
    public function containerResolverAutoResolverConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\AutoResolver - __construct()');

        $resolver = new AutoResolver(new Reflector());

        $I->assertInstanceOf(AutoResolver::class, $resolver);
    }
}

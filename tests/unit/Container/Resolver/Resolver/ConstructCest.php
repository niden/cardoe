<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Resolver;

use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: __construct()
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - __construct()');

        $resolver = new Resolver(new Reflector());
        $I->assertInstanceOf(Resolver::class, $resolver);
    }
}

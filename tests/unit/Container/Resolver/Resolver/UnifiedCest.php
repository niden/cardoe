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
use Phalcon\Container\Resolver\ValueObject;
use UnitTester;

class UnifiedCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: unified()
     *
     * @since  2019-12-31
     */
    public function containerResolverResolverUnified(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - unified()');

        $resolver = new Resolver(new Reflector());
        $I->assertInstanceOf(ValueObject::class, $resolver->unified());

        $resolver->unified()->set('unifiedOne', ['unifiedOne' => 'two']);
        $I->assertEquals(1, $resolver->unified()->count());
    }
}

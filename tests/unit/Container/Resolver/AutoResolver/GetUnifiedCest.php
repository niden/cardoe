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
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use UnitTester;

class GetUnifiedCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\AutoResolver :: getUnified()
     *
     * @since  2019-12-30
     */
    public function containerResolverAutoResolverGetUnified(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\AutoResolver - getUnified()');

        $resolver = new AutoResolver(new Reflector());
        $resolver
            ->parameters()
            ->set(
                ParentFixtureClass::class,
                [
                    'store' => 'tuvok',
                ]
            )
        ;

        $blueprint = $resolver->getUnified(ParentFixtureClass::class);
        $expected  = [
            'store' => 'tuvok',
        ];
        $I->assertEquals($expected, $blueprint->getParameters());
    }
}

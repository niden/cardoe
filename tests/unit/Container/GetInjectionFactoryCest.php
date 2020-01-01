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
use Phalcon\Container\Injection\InjectionFactory;
use UnitTester;

class GetInjectionFactoryCest
{
    /**
     * Unit Tests Phalcon\Container :: getInjectionFactory()
     *
     * @since  2020-01-01
     */
    public function containerGetInjectionFactory(UnitTester $I)
    {
        $I->wantToTest('Container - getInjectionFactory()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $factory   = $container->getInjectionFactory();

        $I->assertInstanceOf(InjectionFactory::class, $factory);
    }
}

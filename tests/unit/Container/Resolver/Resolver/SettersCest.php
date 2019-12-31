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

class SettersCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: setters()
     *
     * @since  2019-12-31
     */
    public function containerResolverResolverSetters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - setters()');

        $resolver = new Resolver(new Reflector());
        $I->assertInstanceOf(ValueObject::class, $resolver->setters());

        $resolver->setters()->set('classOne', ['setOne' => 'two']);
        $I->assertEquals(1, $resolver->setters()->count());
    }
}

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
use Phalcon\Container\Resolver\ValueObject;
use UnitTester;

class TypesCest
{
    /**
     * Unit Tests Phalcon\Container :: types() - resolver
     *
     * @since  2020-01-01
     */
    public function containerTypesResolver(UnitTester $I)
    {
        $I->wantToTest('Container - types() - resolver');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $I->assertNull($container->types());
    }

    /**
     * Unit Tests Phalcon\Container :: types() - autoresolver
     *
     * @since  2020-01-01
     */
    public function containerTypesAutoresolver(UnitTester $I)
    {
        $I->wantToTest('Container - types() - autoresolver');

        $builder   = new Builder();
        $container = $builder->newInstance(true);
        $container->types()->set('typeOne', ['one', 'two']);
        $I->assertInstanceOf(ValueObject::class, $container->types());
        $I->assertEquals(
            [
                'one',
                'two',
            ],
            $container->types()->get('typeOne')
        );
    }
}

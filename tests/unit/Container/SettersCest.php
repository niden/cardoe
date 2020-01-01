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

class SettersCest
{
    /**
     * Unit Tests Phalcon\Container :: setters()
     *
     * @since  2020-01-01
     */
    public function containerSetters(UnitTester $I)
    {
        $I->wantToTest('Container - setters()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container->setters()->set('setterOne', ['one', 'two']);
        $I->assertInstanceOf(ValueObject::class, $container->setters());
        $I->assertEquals(
            [
                'one',
                'two',
            ],
            $container->setters()->get('setterOne')
        );
    }
}

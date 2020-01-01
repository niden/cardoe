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

class ValuesCest
{
    /**
     * Unit Tests Phalcon\Container :: values()
     *
     * @since  2020-01-01
     */
    public function containerValues(UnitTester $I)
    {
        $I->wantToTest('Container - values()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container->values()->set('valueOne', 'two');
        $I->assertInstanceOf(ValueObject::class, $container->values());
        $I->assertEquals(
            'two',
            $container->values()->get('valueOne')
        );
    }
}

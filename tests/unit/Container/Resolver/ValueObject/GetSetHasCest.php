<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\ValueObject;

use Phalcon\Container\Resolver\ValueObject;
use UnitTester;

class GetSetHasCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\ValueObject :: get()/set()/has()
     *
     * @since  2019-12-30
     */
    public function containerResolverValueObjectGetSetHas(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\ValueObject - get()/set()/has()');

        $collection = new ValueObject();

        $collection->set(0, 'one');
        $return = $collection->set('two', 'three');

        $I->assertInstanceOf(ValueObject::class, $return);
        $I->assertTrue($collection->has(0));
        $I->assertTrue($collection->has('two'));
        $I->assertFalse($collection->has('unknown'));

        $I->assertEquals('one', $collection->get(0));
        $I->assertEquals('three', $collection->get('two'));
        $I->assertEquals('default', $collection->get('unknown', 'default'));
    }
}

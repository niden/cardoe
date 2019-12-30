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

class RemoveCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\ValueObject :: remove()
     *
     * @since  2019-12-30
     */
    public function containerResolverValueObjectRemove(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\ValueObject - remove()');

        $collection = new ValueObject();

        $collection->set(0, 'one');
        $collection->set('two', 'three');

        $I->assertTrue($collection->has(0));
        $I->assertTrue($collection->has('two'));

        $collection->remove(0);

        $I->assertFalse($collection->has(0));
        $I->assertTrue($collection->has('two'));
    }
}

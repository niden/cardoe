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

class ClearCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\ValueObject :: clear()
     *
     * @since  2019-12-30
     */
    public function containerResolverValueObjectClear(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\ValueObject - clear()');

        $collection = new ValueObject();
        $I->assertEquals(0, $collection->count());

        $collection->set(0, 'one');
        $collection->set('two', 'three');
        $I->assertEquals(2, $collection->count());

        $collection->clear();
        $I->assertEquals(0, $collection->count());
    }
}

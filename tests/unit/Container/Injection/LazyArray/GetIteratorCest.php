<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\LazyArray;

use UnitTester;

class GetIteratorCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\LazyArray :: getIterator()
     *
     * @since  2019-12-30
     */
    public function containerInjectionLazyArrayGetIterator(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\LazyArray - getIterator()');

        $I->skipTest('Need implementation');
    }
}

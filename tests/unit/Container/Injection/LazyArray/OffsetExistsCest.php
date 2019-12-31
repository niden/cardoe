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

class OffsetExistsCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\LazyArray :: offsetExists()
     *
     * @since  2019-12-30
     */
    public function containerInjectionLazyArrayOffsetExists(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\LazyArray - offsetExists()');

        $I->skipTest('Need implementation');
    }
}

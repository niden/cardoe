<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\LazyNew;

use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\LazyNew :: __construct()
     *
     * @since  2019-12-30
     */
    public function containerInjectionLazyNewConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\LazyNew - __construct()');

        $I->skipTest('Need implementation');
    }
}

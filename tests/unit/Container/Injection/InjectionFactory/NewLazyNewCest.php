<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\InjectionFactory;

use UnitTester;

class NewLazyNewCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\InjectionFactory :: newLazyNew()
     *
     * @since  2019-12-30
     */
    public function containerInjectionInjectionFactoryNewLazyNew(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\InjectionFactory - newLazyNew()');

        $I->skipTest('Need implementation');
    }
}

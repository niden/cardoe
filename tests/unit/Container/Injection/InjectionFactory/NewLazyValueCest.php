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

class NewLazyValueCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\InjectionFactory :: newLazyValue()
     *
     * @since  2019-12-30
     */
    public function containerInjectionInjectionFactoryNewLazyValue(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\InjectionFactory - newLazyValue()');

        $I->skipTest('Need implementation');
    }
}

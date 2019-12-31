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

class NewLazyGetCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\InjectionFactory :: newLazyGet()
     *
     * @since  2019-12-30
     */
    public function containerInjectionInjectionFactoryNewLazyGet(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\InjectionFactory - newLazyGet()');

        $I->skipTest('Need implementation');
    }
}

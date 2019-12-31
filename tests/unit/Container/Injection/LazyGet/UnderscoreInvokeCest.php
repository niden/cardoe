<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\LazyGet;

use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\LazyGet :: __invoke()
     *
     * @since  2019-12-30
     */
    public function containerInjectionLazyGetUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\LazyGet - __invoke()');

        $I->skipTest('Need implementation');
    }
}

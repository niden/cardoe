<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\Lazy;

use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\Lazy :: __invoke()
     *
     * @since  2019-12-30
     */
    public function containerInjectionLazyUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\Lazy - __invoke()');

        $I->skipTest('Need implementation');
    }
}

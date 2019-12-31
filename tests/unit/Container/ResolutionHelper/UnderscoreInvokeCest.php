<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\ResolutionHelper;

use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Container\ResolutionHelper :: __invoke()
     *
     * @since  2019-12-30
     */
    public function containerResolutionHelperUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Container\ResolutionHelper - __invoke()');

        $I->skipTest('Need implementation');
    }
}

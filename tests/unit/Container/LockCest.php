<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use UnitTester;

class LockCest
{
    /**
     * Unit Tests Phalcon\Container :: lock()
     *
     * @since  2019-12-30
     */
    public function containerLock(UnitTester $I)
    {
        $I->wantToTest('Container - lock()');

        $I->skipTest('Need implementation');
    }
}

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

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container :: __construct()
     *
     * @since  2019-12-30
     */
    public function containerConstruct(UnitTester $I)
    {
        $I->wantToTest('Container - __construct()');

        $I->skipTest('Need implementation');
    }
}

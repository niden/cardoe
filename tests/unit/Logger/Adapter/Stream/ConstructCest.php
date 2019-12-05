<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Adapter\Stream;

use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Cardoe\Logger\Adapter\Stream :: __construct()
     *
     * @since  2019-11-30
     */
    public function loggerAdapterStreamConstruct(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - __construct()');

        $I->skipTest('Need implementation');
    }
}
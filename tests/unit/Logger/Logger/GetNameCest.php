<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Logger;

use Cardoe\Logger\Logger;
use UnitTester;

class GetNameCest
{
    /**
     * Tests Cardoe\Logger :: getName()
     */
    public function loggerGetName(UnitTester $I)
    {
        $I->wantToTest('Logger - getName()');
        $logger = new Logger('my-name');

        $expected = 'my-name';
        $actual   = $logger->getName();
        $I->assertEquals($expected, $actual);
    }
}

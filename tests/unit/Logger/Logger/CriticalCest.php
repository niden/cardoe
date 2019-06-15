<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Logger;

use Cardoe\Test\Fixtures\Traits\LoggerTrait;
use UnitTester;

class CriticalCest
{
    use LoggerTrait;

    /**
     * Tests Cardoe\Logger :: critical()
     */
    public function loggerCritical(UnitTester $I)
    {
        $I->wantToTest('Logger - critical()');
        $this->runLoggerFile($I, 'critical');
    }
}

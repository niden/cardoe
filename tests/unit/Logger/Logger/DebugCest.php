<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Logger;

use Cardoe\Test\Fixtures\Traits\LoggerTrait;
use UnitTester;

class DebugCest
{
    use LoggerTrait;

    /**
     * Tests Cardoe\Logger :: debug()
     */
    public function loggerDebug(UnitTester $I)
    {
        $I->wantToTest('Logger - debug()');
        $this->runLoggerFile($I, 'debug');
    }
}

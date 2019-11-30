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

class AlertCest
{
    use LoggerTrait;

    /**
     * Tests Cardoe\Logger :: alert()
     */
    public function loggerAlert(UnitTester $I)
    {
        $I->wantToTest('Logger - alert()');
        $this->runLoggerFile($I, 'alert');
    }
}

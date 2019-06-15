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

class ErrorCest
{
    use LoggerTrait;

    /**
     * Tests Cardoe\Logger :: error()
     */
    public function loggerError(UnitTester $I)
    {
        $I->wantToTest('Logger - error()');
        $this->runLoggerFile($I, 'error');
    }
}

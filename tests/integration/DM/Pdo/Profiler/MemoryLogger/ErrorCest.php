<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Profiler\MemoryLogger;

use IntegrationTester;

class ErrorCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Profiler\MemoryLogger :: error()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerMemoryLoggerError(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\MemoryLogger - error()');

        $I->skipTest('Need implementation');
    }
}

<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Profiler\MemoryLogger;

use IntegrationTester;

class CriticalCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Profiler\MemoryLogger :: critical()
     *
     * @since  2020-01-25
     */
    public function dMPdoProfilerMemoryLoggerCritical(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\MemoryLogger - critical()');

        $I->skipTest('Need implementation');
    }
}

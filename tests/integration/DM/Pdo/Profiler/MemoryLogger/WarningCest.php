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

class WarningCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Profiler\MemoryLogger :: warning()
     *
     * @since  2020-01-25
     */
    public function dMPdoProfilerMemoryLoggerWarning(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\MemoryLogger - warning()');

        $I->skipTest('Need implementation');
    }
}

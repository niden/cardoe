<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Profiler\Profiler;

use Cardoe\DM\Pdo\Profiler\MemoryLogger;
use Cardoe\DM\Pdo\Profiler\Profiler;
use IntegrationTester;

class GetLoggerCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Profiler\Profiler :: getLogger()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerProfilerGetLogger(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\Profiler - getLogger()');

        $profile = new Profiler();
        $logger = $profile->getLogger();

        $I->assertInstanceOf(MemoryLogger::class, $logger);

        $newLogger = new MemoryLogger();
        $profile   = new Profiler($newLogger);

        $logger = $profile->getLogger();
        $I->assertInstanceOf(MemoryLogger::class, $logger);
        $I->assertEquals($newLogger, $logger);
    }
}

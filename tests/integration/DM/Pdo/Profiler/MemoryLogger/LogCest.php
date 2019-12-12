<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Profiler\MemoryLogger;

use Cardoe\DM\Pdo\Profiler\MemoryLogger;
use IntegrationTester;
use Psr\Log\LogLevel;

class LogCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Profiler\MemoryLogger :: log()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerMemoryLoggerLog(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\MemoryLogger - log()');

        $logger  = new MemoryLogger();

        $message = "{method} ({duration} seconds): {statement} {backtrace}";
        $context = [
            "method"    => "f1",
            "duration"  => "123",
            "seconds"   => "456",
            "statement" => "select",
            "backtrace" => "backtrace",
        ];

        $logger->log(LogLevel::INFO, $message, $context);

        $expected = ["f1 (123 seconds): select backtrace"];
        $message  = $logger->getMessages();

        $I->assertEquals($expected, $message);
    }
}
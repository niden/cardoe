<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Profiler\Profiler;

use Phalcon\DM\Pdo\Profiler\Profiler;
use IntegrationTester;
use Psr\Log\LogLevel;

class GetSetLogLevelCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Profiler\Profiler :: getLogLevel()/setLogLevel()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerProfilerGetSetLogLevel(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\Profiler - getLogLevel()/setLogLevel()');

        $profiler = new Profiler();

        $I->assertEquals(
            LogLevel::DEBUG,
            $profiler->getLogLevel()
        );

        $profiler->setLogLevel(LogLevel::INFO);
        $I->assertEquals(
            LogLevel::INFO,
            $profiler->getLogLevel()
        );
    }
}

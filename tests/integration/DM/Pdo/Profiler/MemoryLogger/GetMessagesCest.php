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

class GetMessagesCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Profiler\MemoryLogger :: getMessages()
     *
     * @since  2020-01-25
     */
    public function dMPdoProfilerMemoryLoggerGetMessages(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\MemoryLogger - getMessages()');

        $I->skipTest('Need implementation');
    }
}

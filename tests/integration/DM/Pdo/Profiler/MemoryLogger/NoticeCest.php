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

class NoticeCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Profiler\MemoryLogger :: notice()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerMemoryLoggerNotice(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\MemoryLogger - notice()');

        $I->skipTest('Need implementation');
    }
}

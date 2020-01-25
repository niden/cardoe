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

namespace Phalcon\Test\Integration\DM\Pdo\Profiler\Profiler;

use IntegrationTester;

class FinishCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Profiler\Profiler :: finish()
     *
     * @since  2020-01-25
     */
    public function dMPdoProfilerProfilerFinish(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\Profiler - finish()');

        $I->skipTest('Need implementation');
    }
}

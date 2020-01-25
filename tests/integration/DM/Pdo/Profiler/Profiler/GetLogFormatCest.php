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

class GetLogFormatCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Profiler\Profiler :: getLogFormat()
     *
     * @since  2020-01-25
     */
    public function dMPdoProfilerProfilerGetLogFormat(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\Profiler - getLogFormat()');

        $I->skipTest('Need implementation');
    }
}

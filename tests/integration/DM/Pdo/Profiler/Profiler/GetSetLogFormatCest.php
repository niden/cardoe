<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Profiler\Profiler;

use Cardoe\DM\Pdo\Profiler\Profiler;
use IntegrationTester;

class GetSetLogFormatCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Profiler\Profiler :: getLogFormat()/setLogFormat()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerProfilerGetSetLogFormat(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\Profiler - getLogFormat()/setLogFormat()');


        $profiler = new Profiler();

        $I->assertEquals(
            "{method} ({duration} seconds): {statement} {backtrace}",
            $profiler->getLogFormat()
        );

        $format = "{method} ({duration} seconds): {statement}";
        $profiler->setLogFormat($format);
        $I->assertEquals(
            $format,
            $profiler->getLogFormat()
        );
    }
}

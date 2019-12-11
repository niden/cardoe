<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Connection;
use Cardoe\DM\Pdo\Profiler\Profiler;
use IntegrationTester;

class GetSetProfilerCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: getProfiler()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionGetProfiler(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getProfiler()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $I->assertInstanceOf(
            Profiler::class,
            $connection->getProfiler()
        );

        $profiler = new Profiler();
        $connection->setProfiler($profiler);

        $I->assertSame($profiler, $connection->getProfiler());
    }
}

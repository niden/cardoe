<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Profiler\Profiler;
use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;

class GetSetProfilerCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: getProfiler()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionGetProfiler(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getProfiler()');

        $I->assertInstanceOf(
            Profiler::class,
            $this->connection->getProfiler()
        );

        $profiler = new Profiler();
        $this->connection->setProfiler($profiler);

        $I->assertSame($profiler, $this->connection->getProfiler());
    }
}

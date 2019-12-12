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

class IsSetActiveCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Profiler\Profiler :: isActive()/setActive()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerProfilerIsSetActive(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\Profiler - isActive()/setActive()');

        $profiler = new Profiler();

        $I->assertFalse($profiler->isActive());

        $profiler->setActive(true);
        $I->assertTrue($profiler->isActive());
    }
}
<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Profiler\Profiler;

use IntegrationTester;

class IsActiveCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Profiler\Profiler :: isActive()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerProfilerIsActive(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\Profiler - isActive()');

        $I->skipTest('Need implementation');
    }
}

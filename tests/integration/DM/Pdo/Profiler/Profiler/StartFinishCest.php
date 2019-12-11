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

use function sleep;
use function strpos;

class StartFinishCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Profiler\Profiler :: start()/finish()
     *
     * @since  2019-12-11
     */
    public function dMPdoProfilerProfilerStartFinish(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Profiler\Profiler - start()/finish()');

        $profiler = new Profiler();

        $profiler
            ->setActive(true)
            ->start('my-method')
        ;

        sleep(1);
        $profiler->finish('select from something', [1 => 2]);

        $logger  = $profiler->getLogger();
        $message = $logger->getMessages()[0];

        $I->assertNotFalse(strpos($message, 'my-method (1.'));
        $I->assertNotFalse(strpos($message, 'select from something #0'));
    }
}

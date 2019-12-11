<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use IntegrationTester;

class UnderscoreCallCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: __call()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionUnderscoreCall(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - __call()');

        $I->skipTest('Need implementation');
    }
}

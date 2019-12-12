<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection\Decorated;

use IntegrationTester;

class DisconnectCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection\Decorated :: disconnect()
     *
     * @since  2019-12-12
     */
    public function dMPdoConnectionDecoratedDisconnect(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection\Decorated - disconnect()');

        $I->skipTest('Need implementation');
    }
}

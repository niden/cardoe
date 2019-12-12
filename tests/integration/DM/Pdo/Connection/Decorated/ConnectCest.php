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

class ConnectCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection\Decorated :: connect()
     *
     * @since  2019-12-12
     */
    public function dMPdoConnectionDecoratedConnect(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection\Decorated - connect()');

        $I->skipTest('Need implementation');
    }
}

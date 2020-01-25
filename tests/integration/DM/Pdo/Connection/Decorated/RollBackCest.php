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

namespace Phalcon\Test\Integration\DM\Pdo\Connection\Decorated;

use IntegrationTester;

class RollBackCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection\Decorated :: rollBack()
     *
     * @since  2020-01-25
     */
    public function dMPdoConnectionDecoratedRollBack(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection\Decorated - rollBack()');

        $I->skipTest('Need implementation');
    }
}

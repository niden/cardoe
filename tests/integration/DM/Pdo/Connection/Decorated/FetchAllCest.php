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

class FetchAllCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection\Decorated :: fetchAll()
     *
     * @since  2020-01-25
     */
    public function dMPdoConnectionDecoratedFetchAll(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection\Decorated - fetchAll()');

        $I->skipTest('Need implementation');
    }
}

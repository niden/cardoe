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

class FetchValueCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection\Decorated :: fetchValue()
     *
     * @since  2020-01-25
     */
    public function dMPdoConnectionDecoratedFetchValue(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection\Decorated - fetchValue()');

        $I->skipTest('Need implementation');
    }
}

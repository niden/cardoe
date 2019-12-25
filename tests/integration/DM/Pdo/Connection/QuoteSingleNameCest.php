<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use IntegrationTester;

class QuoteSingleNameCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: quoteSingleName()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionQuoteSingleName(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - quoteSingleName()');

        $I->skipTest('Need implementation');
    }
}

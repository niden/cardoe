<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\ConnectionLocator;

use IntegrationTester;

class GetReadCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\ConnectionLocator :: getRead()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionLocatorGetRead(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\ConnectionLocator - getRead()');

        $I->skipTest('Need implementation');
    }
}

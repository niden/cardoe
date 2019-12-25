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

class SetReadCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\ConnectionLocator :: setRead()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionLocatorSetRead(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\ConnectionLocator - setRead()');

        $I->skipTest('Need implementation');
    }
}

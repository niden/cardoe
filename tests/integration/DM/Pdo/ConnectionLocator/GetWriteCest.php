<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\ConnectionLocator;

use IntegrationTester;

class GetWriteCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\ConnectionLocator :: getWrite()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionLocatorGetWrite(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\ConnectionLocator - getWrite()');

        $I->skipTest('Need implementation');
    }
}

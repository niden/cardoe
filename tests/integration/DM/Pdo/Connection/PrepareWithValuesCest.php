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

class PrepareWithValuesCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: prepareWithValues()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionPrepareWithValues(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - prepareWithValues()');

        $I->skipTest('Need implementation');
    }
}

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

class PrepareWithValuesCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: prepareWithValues()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionPrepareWithValues(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - prepareWithValues()');

        $I->skipTest('Need implementation');
    }
}

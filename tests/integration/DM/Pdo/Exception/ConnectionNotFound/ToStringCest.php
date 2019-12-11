<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Exception\ConnectionNotFound;

use IntegrationTester;

class ToStringCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Exception\ConnectionNotFound :: __toString()
     *
     * @since  2019-12-11
     */
    public function dMPdoExceptionConnectionNotFoundToString(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Exception\ConnectionNotFound - __toString()');

        $I->skipTest('Need implementation');
    }
}

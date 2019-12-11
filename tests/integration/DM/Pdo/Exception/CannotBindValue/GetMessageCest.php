<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Exception\CannotBindValue;

use IntegrationTester;

class GetMessageCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Exception\CannotBindValue :: getMessage()
     *
     * @since  2019-12-11
     */
    public function dMPdoExceptionCannotBindValueGetMessage(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Exception\CannotBindValue - getMessage()');

        $I->skipTest('Need implementation');
    }
}

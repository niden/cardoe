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

class GetCodeCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Exception\CannotBindValue :: getCode()
     *
     * @since  2019-12-11
     */
    public function dMPdoExceptionCannotBindValueGetCode(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Exception\CannotBindValue - getCode()');

        $I->skipTest('Need implementation');
    }
}

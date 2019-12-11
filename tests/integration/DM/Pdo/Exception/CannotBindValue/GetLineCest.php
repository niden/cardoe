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

class GetLineCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Exception\CannotBindValue :: getLine()
     *
     * @since  2019-12-11
     */
    public function dMPdoExceptionCannotBindValueGetLine(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Exception\CannotBindValue - getLine()');

        $I->skipTest('Need implementation');
    }
}

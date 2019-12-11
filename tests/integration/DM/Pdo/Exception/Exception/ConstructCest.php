<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Exception\Exception;

use IntegrationTester;

class ConstructCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Exception\Exception :: __construct()
     *
     * @since  2019-12-11
     */
    public function dMPdoExceptionExceptionConstruct(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Exception\Exception - __construct()');

        $I->skipTest('Need implementation');
    }
}

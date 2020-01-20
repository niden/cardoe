<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Query\Select;

use IntegrationTester;

class PerformCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: perform()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectPerform(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - perform()');

        $I->skipTest('Need implementation');
    }
}

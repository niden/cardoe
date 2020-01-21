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
use Phalcon\DM\Query\QueryFactory;

class SetFlagCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: setFlag()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectSetFlag(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - setFlag()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->setFlag("LOW_PRIORITY")
        ;

        $expected = "SELECT LOW_PRIORITY * FROM co_invoices";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }
}

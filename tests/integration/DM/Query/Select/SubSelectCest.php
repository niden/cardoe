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

class SubSelectCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: subSelect()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectSubSelect(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - subSelect()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from(
                $select
                    ->subSelect()
                    ->columns("inv_id")
                    ->from('co_invoices')
                    ->as('inv')
                    ->getStatement()
            );

        $expected = "SELECT * FROM (SELECT inv_id FROM co_invoices) AS inv";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }
}

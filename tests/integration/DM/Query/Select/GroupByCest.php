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

class GroupByCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: groupBy()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectGroupBy(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - groupBy()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->groupBy('inv_cst_id')
            ->groupBy('inv_status_flag')
        ;

        $expected = "SELECT * FROM co_invoices "
            . "GROUP BY inv_cst_id, inv_status_flag";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }
}

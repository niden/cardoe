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

class OrderByCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: orderBy()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectOrderBy(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - orderBy()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->orderBy(
                [
                    'inv_cst_id',
                    'UPPER(inv_title)',
                ]
            )
        ;


        $expected = "SELECT * FROM co_invoices "
            . "ORDER BY inv_cst_id, UPPER(inv_title)";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }
}

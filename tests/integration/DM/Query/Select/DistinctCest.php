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

class DistinctCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: distinct()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectDistinct(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - distinct()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->distinct()
            ->from('co_invoices')
            ->columns('inv_id', 'inc_cst_id')
        ;

        $expected = "SELECT DISTINCT inv_id, inc_cst_id FROM co_invoices";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: distinct() - twice
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectDistinctTwice(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - distinct() - twice');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->distinct()
            ->distinct()
            ->from('co_invoices')
            ->columns('inv_id', 'inc_cst_id')
        ;

        $expected = "SELECT DISTINCT inv_id, inc_cst_id FROM co_invoices";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: distinct() - unset
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectDistinctUnset(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - distinct() - unset');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->distinct()
            ->distinct(false)
            ->from('co_invoices')
            ->columns('inv_id', 'inc_cst_id')
        ;

        $expected = "SELECT inv_id, inc_cst_id FROM co_invoices";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }
}

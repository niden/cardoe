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

class WhereCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: where()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectWhere(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - where()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->where('inv_id > ', 1)
        ;

        $expected = "SELECT * FROM co_invoices WHERE inv_id > :__1__";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);

        $expected = [
            '__1__' => [1, 1],
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: where() - bind values
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectWhereBind(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - where() - bind values');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->where('inv_id > 1')
            ->andWhere('inv_total > :total')
            ->andWhere('inv_cst_id IN ', [1, 2, 3])
            ->catWhere(' AND inv_status_flag = ' . $select->bindInline(1))
            ->bindValue('total', 100)
        ;

        $expected = "SELECT * FROM co_invoices "
            . "WHERE inv_id > 1 AND inv_total > :total "
            . "AND inv_cst_id IN (:__1__, :__2__, :__3__) "
            . "AND inv_status_flag = :__4__";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);

        $expected = [
            '__1__' => [1, 1],
            '__2__' => [2, 1],
            '__3__' => [3, 1],
            '__4__' => [1, 1],
            'total' => [100, 1],
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: orWhere() - bind values
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectOrWhereBind(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - orWhere() - bind values');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->catWhere('inv_total > ', 100)
            ->orWhere("inv_status_flag = :status")
            ->bindValue('status', 1)
        ;

        $expected = "SELECT * FROM co_invoices "
            . "WHERE inv_total > :__1__ "
            . "OR inv_status_flag = :status";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);

        $expected = [
            '__1__'  => [100, 1],
            'status' => [1, 1],
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);
    }
}
